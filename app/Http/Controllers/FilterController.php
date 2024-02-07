<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Models\Product;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class FilterController extends Controller {
    public function generateLabels(Request $request) {
        $request->validate([
            'page_size' => 'required',
            'label_width' => 'required|numeric|min:0',
            'label_height' => 'required|numeric|min:0',
            'orientation' => 'required|in:portrait,landscape', // Assuming only two orientations are allowed
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'apply_range' => 'boolean',
            'start_label_position' => 'required_if:apply_range,true|integer|min:1',
            'end_label_position' => 'required_if:apply_range,true|integer|min:1|gte:start_label_position', // End position must be greater than or equal to start position
        ]);

        $page_size = $request->input('page_size');
        $label_width = $request->input('label_width');
        $label_height = $request->input('label_height');
        $orientation = $request->input('orientation');
        $date_start = $request->input('date_start'); // Assuming you have a date picker field
        $date_end = $request->input('date_end');
        $apply_range = $request->input('apply_range');
        $start_label_position = $request->input('start_label_position');
        $end_label_position = $request->input('end_label_position');
        $page_margin = 10;

        // Fetch products and apply filters
        $labelsQuery = Product::with('attributes')
            ->where('date', '>=', $date_start)
            ->where('date', '<=', $date_end);

        if ($apply_range) {
            $labelsQuery->whereBetween('id', [$start_label_position, $end_label_position]);
        }

        $labels = $labelsQuery->get();

        // Initialize MPDF with appropriate paper size and orientation
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $page_size,
            'orientation' => $orientation // Set orientation explicitly
        ]);

        // Set page margins
        $mpdf->SetMargins($page_margin, $page_margin, $page_margin);

        // Calculate number of labels per row
        $pageWidth = $mpdf->w; // Page width
        $labelsPerRow = floor(($pageWidth - 2 * $page_margin) / ($label_width + $page_margin));

        // Initialize variables for label positioning
        $x = $page_margin;
        $y = $page_margin;

        $html = '<table style="width: 100%;">';

        // Initialize a counter to keep track of the labels in each row
        $counter = 0;

        // Iterate through labels
        foreach ($labels as $label) {
            // Retrieve product code
            $productCode = $label->code;

            // Iterate through product attributes
            foreach ($label->attributes as $attribute) {
                // Retrieve attribute details
                $color = $attribute->color;
                $size = $attribute->size;

                // Format label content
                $labelContent = sprintf("%s\nColor: %s\nSize: %s", $productCode, $color, $size);

                // Add label content to PDF
                $mpdf->SetXY($x, $y); // Set position
                // Check if a new row needs to be started
                if ($counter % $labelsPerRow === 0) {
                    $html .= '<tr>';
                }

                // Add label content to PDF
                $html .= '<td style="width: ' . $label_width . 'mm; height: ' . $label_height . 'mm; border: 1px solid black; padding: 2mm;">' . $labelContent . '</td>';

                // Increment the counter
                $counter++;

                // Check if it's time to end the row
                if ($counter % $labelsPerRow === 0) {
                    $html .= '</tr>';
                }
                // Move to the next column
                $x += $label_width + $page_margin;

                // Check if reached the end of the row
                if ($x + $label_width > $pageWidth - $page_margin) {
                    // Move to the next row
                    $x = $page_margin; // Reset x-coordinate
                    $y += $label_height + $page_margin; // Move to the next row

                    // Check if a page break is needed
                    if ($y + $label_height > $mpdf->h - $page_margin) {
                        $mpdf->AddPage(); // Add a new page
                        $x = $page_margin; // Reset x-coordinate
                        $y = $page_margin; // Reset y-coordinate
                    }
                }
            }
        }

        // Check if the last row needs to be closed
        if ($counter % $labelsPerRow !== 0) {
            $remainingCells = $labelsPerRow - ($counter % $labelsPerRow);
            $html .= '<td colspan="' . $remainingCells . '"></td></tr>'; // Fill the remaining cells in the last row
        }

        $html .= '</table>';

        $mpdf->WriteHTML($html);

        // Generate filename based on current date and time
        $filename = 'labels_' . date('Ymd_His') . '.pdf';

        // Ensure the storage directory exists
        $storagePath = storage_path('app/public/labels');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true); // Create directory if it doesn't exist
        }

        // Output the PDF to storage with the dynamic filename
        $mpdf->Output($storagePath . '/' . $filename, 'F');

        $data = [
            'page_size' => $page_size,
            'label_width' => $label_width,
            'label_height' => $label_height,
            'orientation' => $orientation,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'start_label_position' => $start_label_position,
            'end_label_position' => $end_label_position,
            'pdf' => $filename,
        ];

        Labels::create($data);

        return redirect('/')->with('success', 'Label created successfully!');
    }
}