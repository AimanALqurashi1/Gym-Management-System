{{-- resources/views/trainer/assign-form.blade.php --}}

<h3>Assign Courses to: {{ $trainer->name }}</h3>

<form id="assign-courses-form">
    @csrf
    <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">

    <div style="max-height: 400px; overflow-y: auto; padding: 10px;">
        @foreach ($courses as $course)
            <div style="margin-bottom: 10px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="course_ids[]" value="{{ $course->id }}"
                        {{ in_array($course->id, $assignedCourseIds) ? 'checked' : '' }} style="margin-right: 10px;">
                    <div>
                        <strong>{{ $course->name }}</strong><br>
                        <small>{{ $course->description ?? 'No description' }}</small><br>
                        <small>Duration: {{ $course->duration ?? 'N/A' }}</small>
                    </div>
                </label>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 20px; text-align: right;">
        <button type="button" class="btn btn-secondary modal-close" style="margin-right: 10px;">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Assignments</button>
    </div>
</form>

<style>
    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary:hover {
        background-color: #545b62;
    }
</style>

<script>
    // Handle cancel button
    $(document).on('click', '.modal-close', function() {
        $('#assign-modal').modal('hide');
    });
</script>
