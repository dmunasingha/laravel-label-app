@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3>Label History</h3>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead class="">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Page Size</th>
                                    <th scope="col">Label Width</th>
                                    <th scope="col">Label Height</th>
                                    <th scope="col">Orientation</th>
                                    <th scope="col">Date Start</th>
                                    <th scope="col">Date End</th>
                                    <th scope="col">Start Label Position</th>
                                    <th scope="col">End Label Position</th>
                                    <th scope="col">Labels</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr class="">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->page_size }}</td>
                                        <td>{{ $item->label_width }}</td>
                                        <td>{{ $item->label_height }}</td>
                                        <td>{{ $item->orientation }}</td>
                                        <td>{{ $item->date_start }}</td>
                                        <td>{{ $item->date_end }}</td>
                                        <td>{{ $item->start_label_position ?? '-' }}</td>
                                        <td>{{ $item->end_label_position ?? '-' }}</td>
                                        <td>
                                            <a href="{{ asset('storage/labels/' . $item->pdf) }}" target="__blank">View
                                                Labels</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
