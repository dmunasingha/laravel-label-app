@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h3>Filters</h3>
                    <hr>
                    <form action="{{ route('generate-labels') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="page_size">Page Size:</label>
                                <select name="page_size" class="form-control" id="page_size">
                                    <option value="A4" {{ $labels ?? $labels->page_size == 'A4' ? 'selected' : '' }}>A4
                                    </option>
                                    <option value="Letter"{{ $labels ?? $labels->page_size == 'Letter' ? 'selected' : '' }}>
                                        Letter
                                    </option>
                                </select>
                                @error('page_size')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="label_width">Label Width:</label>
                                        <input type="number" class="form-control" name="label_width" id="label_width"
                                            min="1" required value="{{ $labels ?? $labels->label_width }}">
                                        @error('label_width')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="label_height">Label Height:</label>
                                        <input type="number" class="form-control" name="label_height" id="label_height"
                                            min="1" required value="{{ $labels ?? $labels->label_height }}">
                                        @error('label_height')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="orientation">Orientation:</label>
                                <div class="d-flex gap-3">
                                    <input type="radio" class="form-check-input" name="orientation" id="portrait"
                                        value="portrait"
                                        {{ $labels ?? $labels->orientation == 'portrait' ? 'checked' : 'checked' }}>
                                    <label for="portrait">Portrait</label>
                                    <input type="radio" class="form-check-input" name="orientation" id="landscape"
                                        value="landscape"{{ $labels ?? $labels->orientation == 'landscape' ? 'checked' : '' }}>
                                    <label for="landscape">Landscape</label>
                                </div>
                                @error('orientation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_start">Date From:</label>
                                <input type="date" class="form-control" name="date_start" id="date_start"
                                    value="{{ $labels ?? $labels->date_start }}">
                                @error('date_start')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_end">Date To:</label>
                                <input type="date" class="form-control" name="date_end" id="date_end"
                                    value="{{ $labels ?? $labels->date_end }}">
                                @error('date_end')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="row">
                                <div class="col-2">
                                    <label for="apply_range">Apply Range:</label>
                                    <input type="checkbox" class="form-check" name="apply_range" id="apply_range">
                                </div>
                                @error('apply_range')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="col-md-5">
                                    <label for="start_label_position">Start Label Position:</label>
                                    <input type="number" class="form-control" name="start_label_position"
                                        id="start_label_position" disabled
                                        value="{{ $labels ?? $labels->start_label_position }}">
                                    @error('start_label_position')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="end_label_position">End Label Position:</label>
                                    <input type="number" class="form-control" name="end_label_position"
                                        id="end_label_position" disabled
                                        value="{{ $labels ?? $labels->end_label_position }}">
                                    @error('end_label_position')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Generate Labels</button>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            @if (isset($labels->pdf))
                <div class="card mt-5">
                    <div class="card-body" style="height: 80vh">
                        <iframe src="{{ asset('storage/labels/' . $labels->pdf) }}" frameborder="0" allowfullscreen
                            width="100%" height="100%"></iframe>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <script>
        const applyRangeCheckbox = document.getElementById('apply_range');
        const startPositionInput = document.getElementById('start_label_position');
        const endPositionInput = document.getElementById('end_label_position');

        applyRangeCheckbox.addEventListener('change', () => {
            if (applyRangeCheckbox.checked) {
                startPositionInput.disabled = false;
                endPositionInput.disabled = false;
            } else {
                startPositionInput.disabled = true;
                endPositionInput.disabled = true;
            }
        });
    </script>
@endsection
