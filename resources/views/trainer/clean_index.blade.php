@extends('layouts.home')
@section('title', 'Trainers Management')
@section('css')

    <style>
        /* Trainer Cards Specific Styles - Light Theme */
        .trainer-collection {
            padding: 20px 30px;
        }

        .collection-head {
            margin-bottom: 30px;
            text-align: center;
        }

        .collection-head h2 {
            font-size: 2.5rem;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .collection-head h2 i {
            color: var(--primary);
            margin: 0 15px;
            font-size: 2rem;
        }

        .collection-head h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        .trainer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .trainer-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .trainer-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }

        .trainer-img-wrapper {
            width: 100%;
            height: 250px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .trainer-img-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
            pointer-events: none;
        }

        .trainer-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .trainer-card:hover .trainer-img {
            transform: scale(1.1);
        }

        .trainer-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            padding: 15px 20px 5px;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Montserrat', sans-serif;
        }

        .trainer-name:hover {
            color: var(--primary);
        }

        .trainer-specialty {
            padding: 0 20px 15px;
            color: var(--gray);
            font-size: 0.95rem;
            cursor: pointer;
            flex-grow: 1;
        }

        .trainer-specialty span {
            display: inline-block;
            background: var(--primary-light);
            padding: 5px 12px;
            border-radius: 20px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .trainer-bio {
            padding: 0 20px 15px;
            color: var(--gray);
            font-size: 0.9rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .trainer-social {
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 15px;
            justify-content: center;
            background: #fafafa;
        }

        .trainer-social a {
            color: var(--gray);
            font-size: 1.1rem;
            transition: var(--transition);
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: white;
            border: 1px solid var(--border-color);
            text-decoration: none;
        }

        .trainer-social a:hover {
            color: white;
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        /* Add Card Styles - Light Theme */
        .trainer-card.add-card {
            background: linear-gradient(135deg, var(--primary-light), white);
            border: 2px dashed var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            cursor: pointer;
        }

        .trainer-card.add-card:hover {
            background: linear-gradient(135deg, rgba(255, 85, 0, 0.15), #f8f9fa);
            border-color: var(--primary);
        }

        .add-card-content {
            text-align: center;
            padding: 30px;
        }

        .add-icon-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
        }

        .add-icon-wrapper i {
            font-size: 50px;
            color: white;
        }

        .trainer-card.add-card h1 {
            color: var(--dark);
            font-size: 1.8rem;
            margin: 0;
        }

        .trainer-card.add-card p {
            color: var(--gray);
            margin-top: 10px;
        }

        .trainer-card.add-card:hover .add-icon-wrapper {
            transform: scale(1.1) rotate(90deg);
        }

        /* Button Styles for Assign Courses - Light Theme */
        .trainer-card .assign-courses {
            margin: 0 20px 15px;
            padding: 12px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(255, 85, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .trainer-card .assign-courses:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .trainer-card .assign-courses:active {
            transform: translateY(0);
        }

        /* Modal Styles - Light Theme */
        #assign-modal .modal-content {
            max-width: 500px;
            background: white;
            border-radius: var(--border-radius);
        }

        #assign-modal .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 20px 25px;
        }

        #assign-modal .modal-header h3 {
            color: white;
            margin: 0;
        }

        #assign-modal .modal-body {
            background: white;
            padding: 25px;
        }

        .course-checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .course-checkbox-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .course-checkbox-item:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .course-checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .course-checkbox-item label {
            color: var(--dark);
            font-size: 0.95rem;
            cursor: pointer;
            flex: 1;
        }

        .no-trainers {
            grid-column: 1/-1;
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px dashed var(--border-color);
        }

        .no-trainers p {
            color: var(--gray);
            font-size: 1.2rem;
            margin: 0;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .trainer-collection {
                padding: 15px;
            }

            .collection-head h2 {
                font-size: 1.8rem;
            }

            .collection-head h2 i {
                font-size: 1.5rem;
                margin: 0 8px;
            }

            .trainer-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }

            .trainer-card .assign-courses {
                margin: 0 15px 15px;
                padding: 10px 15px;
                font-size: 0.8rem;
            }

            .trainer-name {
                font-size: 1.2rem;
                padding: 12px 15px 5px;
            }

            .trainer-specialty,
            .trainer-bio {
                padding: 0 15px 12px;
            }

            .trainer-social {
                padding: 12px 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="trainer-collection">
        <!-- header with icon -->
        <div class="collection-head">
            <h2>
                <i class="fas fa-dumbbell"></i>
                elite trainers
                <i class="fas fa-person-walking"></i>
            </h2>
        </div>

        <!-- grid of trainers -->
        <div class="trainer-grid">
            <!-- Add New Trainer Card -->
            <a href="{{ route('trainer.create') }}" class="trainer-card add-card">
                <div class="add-card-content">
                    <div class="add-icon-wrapper">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h1>Add New</h1>
                    <p style="color: var(--gray-light); margin-top: 15px;">Create new trainer profile</p>
                </div>
            </a>

            <!-- Trainer Cards -->
            @forelse($data as $trainer)
                <div class="trainer-card">
                    <!-- Clickable image wrapper -->
                    <div class="trainer-img-wrapper"
                        onclick="window.location='{{ route('trainer.trainerClases', $trainer->id) }}'">
                        @if (!empty($trainer->photo) && $trainer->photo !== null)
                            <img class="trainer-img" src="{{ asset('admin/uploads') . '/' . $trainer->photo }}"
                                alt="{{ $trainer->name }}" loading="lazy">
                        @else
                            @if ($trainer->gender == 'female')
                                <img class="trainer-img" src="{{ asset('admin/uploads/femaleLogo.jpg') }}"
                                    alt="{{ $trainer->name }}" loading="lazy">
                            @else
                                <img class="trainer-img" src="{{ asset('admin/uploads/maleLogo.png') }}"
                                    alt="{{ $trainer->name }}" loading="lazy">
                            @endif
                        @endif
                    </div>

                    <!-- Clickable name -->
                    <div class="trainer-name"
                        onclick="window.location='{{ route('trainer.trainerClases', $trainer->id) }}'">
                        {{ $trainer->name }}
                    </div>

                    @if ($trainer->has_courses)
                        <!-- Clickable specialty section -->
                        <div class="trainer-specialty"
                            onclick="window.location='{{ route('trainer.trainerClases', $trainer->id) }}'">
                            <span>{{ $trainer->course_names_string }}</span>
                        </div>
                    @else
                        <!-- Assign Courses Button -->
                        <button class="btn assign-courses" data-id="{{ $trainer->id }}" data-name="{{ $trainer->name }}">
                            <i class="fas fa-book-open" style="margin-right: 8px;"></i>
                            Assign Courses
                        </button>
                    @endif

                    <div class="trainer-bio">{{ $trainer->bio ?? 'No bio available' }}</div>

                    <div class="trainer-social">
                        <a href="{{ route('trainer.show', $trainer->id) }}" class="btn-icon" title="View Details"
                            style="color: white; background: var(--primary-light);">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('trainer.edit', $trainer->id) }}" class="btn-icon" title="Edit Trainer"
                            style="color: white; background: var(--warning);">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('trainer.destroy', $trainer->id) }}" method="POST" style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this trainer? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" title="Delete Trainer"
                                style="background: none; border: none; color: white; background: var(--danger); padding: 8px 12px; border-radius: 50%; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="no-trainers">
                    <i class="fas fa-users-slash"
                        style="font-size: 3rem; color: var(--gray-light); margin-bottom: 15px;"></i>
                    <p>No trainers found. Click "Add New" to create your first trainer.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Assign Courses Modal -->
    <div class="modal" id="assign-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-book-open" style="margin-right: 10px; color: var(--primary);"></i> Assign Courses</h3>
                <button class="modal-close close-modal" id="close-modal">&times;</button>
            </div>
            <div class="modal-body" id="assign-modal-body">
                <!-- AJAX content will load here -->
                <div style="text-align: center; padding: 30px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary);"></i>
                    <p style="margin-top: 15px; color: var(--gray-light);">Loading courses...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (if needed) -->
    <div class="modal" id="edit-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit" style="margin-right: 10px; color: var(--primary);"></i> Edit Member</h3>
                <button class="modal-close close-modal" id="close-edit-modal">&times;</button>
            </div>
            <div class="modal-body" id="edit-modal-body">
                <!-- AJAX content will load here -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Load assign courses modal
            $(document).on('click', '.assign-courses', function(e) {
                // Prevent any default action

                var id = $(this).data("id");
                var name = $(this).data("name");

                console.log("Trainer ID:", id);
                console.log("Trainer Name:", name);

                // Show loading state
                $("#assign-modal-body").html(`
                    <div style="text-align: center; padding: 30px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary);"></i>
                        <p style="margin-top: 15px; color: var(--gray-light);">Loading courses for ${name}...</p>
                    </div>
                `);

                // Show modal immediately with loading state
                $("#assign-modal").addClass('active');

                // Load content via AJAX
                $.ajax({
                    url: '{{ route('trainer.load_assign_form') }}',
                    type: 'post',
                    dataType: 'html',
                    cache: false,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        trainer_id: id,
                        trainer_name: name
                    },
                    success: function(data) {
                        $("#assign-modal-body").html(data);
                    },
                    error: function(xhr, status, error) {
                        $("#assign-modal-body").html(`
                            <div style="text-align: center; padding: 30px; color: var(--danger);">
                                <i class="fas fa-exclamation-circle" style="font-size: 3rem; margin-bottom: 15px;"></i>
                                <p>Sorry, something went wrong. Please try again.</p>
                                <p style="font-size: 0.9rem; margin-top: 10px;">${error}</p>
                                <button class="btn btn-sm btn-primary" onclick="$('#assign-modal').removeClass('active');" style="margin-top: 15px;">Close</button>
                            </div>
                        `);
                    }
                });
            });

            // Handle form submission
            $(document).on('submit', '#assign-courses-form', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('trainer.assign_courses') }}',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: formData + '&_token={{ csrf_token() }}',
                    beforeSend: function() {
                        // Show loading state on submit button
                        var submitBtn = $('#assign-courses-form button[type="submit"]');
                        submitBtn.prop('disabled', true);
                        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#assign-modal").removeClass('active');

                            // Show success message (you can use toast or alert)
                            alert(response.message);

                            // Reload the page to show updated data
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errorMsg = "Error: ";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg += xhr.responseJSON.message;
                        } else {
                            errorMsg += "Something went wrong";
                        }

                        // Show error in modal
                        if ($('#assign-modal-body').find('.alert').length) {
                            $('#assign-modal-body').find('.alert').remove();
                        }
                        $('#assign-modal-body').prepend(
                            '<div class="alert alert-danger" style="margin-bottom: 20px;">' +
                            '<i class="fas fa-exclamation-circle"></i> ' + errorMsg +
                            '<button type="button" class="close" onclick="$(this).parent().remove()">&times;</button>' +
                            '</div>'
                        );

                        // Re-enable submit button
                        var submitBtn = $('#assign-courses-form button[type="submit"]');
                        submitBtn.prop('disabled', false);
                        submitBtn.html('Assign Courses');
                    }
                });
            });

            // Close modal when clicking close button
            $(document).on('click', '.close-modal', function() {
                $(this).closest('.modal').removeClass('active');
            });

            // Close modal when clicking outside
            $(document).on('click', '.modal', function(e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).removeClass('active');
                }
            });

            // Prevent clicks inside modal content from closing it
            $(document).on('click', '.modal-content', function(e) {
                e.stopPropagation();
            });

            // Handle delete confirmation with dashboard styling
            $(document).on('click', '.delete-trainer', function(e) {
                e.preventDefault();
                if (confirm(
                        'Are you sure you want to delete this trainer? This action cannot be undone.')) {
                    var formId = $(this).data('form');
                    $('#' + formId).submit();
                }
            });
        });
    </script>
@endsection
