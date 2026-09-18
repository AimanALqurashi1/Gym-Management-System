@extends('layouts.home')
@section('css')
    <!-- Member page specific CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/memberStyle3LightTheme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/searchStyle1.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/uploadimgae1.css') }}">

    <style>
        /* Custom notification styles */
        .custom-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            padding: 15px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .custom-notification.success {
            background: #28a745;
            color: white;
        }

        .custom-notification.error {
            background: #dc3545;
            color: white;
        }

        .custom-notification.warning {
            background: #ffc107;
            color: #333;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding: 30px">
        <header>
            <h1><i class="fas fa-users"></i> Member Directory</h1>
            <p class="subtitle">Click on any row to view detailed information</p>
        </header>

        <div class="row">
            <div class="col-md-9">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input style="color: white" type="text" id="searchInput" name="searchInput"
                        placeholder="Search members by name, role, or department...">
                </div>
            </div>
            <div class="col-md-3">
                <a class="btn-add" id="add-member-btn" data-toggle="modal" data-target="#member-modal">
                    <i class="fas fa-plus"></i> Add Member
                </a>
            </div>
        </div>

        <div class="members-container" id="members-container">
            @foreach ($data as $member)
                @php
                    $statusClass = 'status-' . strtolower($member['status'] ?? 'unknown');
                    $badgeClass = 'badge ' . ($member['memberType'] ?? 'member');

                    $joinDateDisplay = 'N/A';
                    if (!empty($member['joinDate'])) {
                        try {
                            $joinDate = new DateTime($member['joinDate']);
                            $joinDateDisplay = $joinDate->format('F j, Y');
                        } catch (Exception $e) {
                            $joinDateDisplay = $member['joinDate'];
                        }
                    }

                    $notes = $member['notes'] ?? 'No additional notes.';
                @endphp

                <div class="member-row" data-id="{{ $member['id'] }}">
                    @if (!@empty($member->photo) && $member->photo !== null)
                        <img src="{{ asset('admin/uploads') . '/' . $member->photo }}" alt="{{ $member['name'] }}"
                            class="member-avatar">
                    @else
                        @if ($member->gender == 'female')
                            <img src="{{ asset('admin/uploads/femaleLogo.jpg') }}" alt="{{ $member['name'] }}"
                                class="member-avatar">
                        @else
                            <img src="{{ asset('admin/uploads/maleLogo.png') }}" alt="{{ $member['name'] }}"
                                class="member-avatar">
                        @endif
                    @endif

                    <div class="member-info">
                        <div>
                            <div class="member-name">{{ $member['name'] ?? 'Unknown' }}
                                <span class="{{ $badgeClass }}">
                                    {{ strtoupper($member['memberType'] ?? 'member') }}
                                </span>
                            </div>
                            <div class="member-department">{{ $member['department'] ?? 'Not specified' }}</div>
                        </div>
                        <div class="member-role">{{ $member['role'] ?? 'No role specified' }}</div>
                        <div class="member-contact">
                            <div><i class="fas fa-envelope"></i> {{ $member['email'] ?? 'No email' }}</div>
                            <div><i class="fas fa-phone"></i> {{ $member['phone'] ?? 'No phone' }}</div>
                        </div>
                        <div class="member-status {{ $statusClass }}">
                            <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                            {{ $member['status'] ?? 'Unknown' }}
                        </div>

                        <div class="row">
                            <button data-id="{{ $member->id }}" data-member_code="{{ $member->code }}"
                                style="background:none" class=" btn load_edit_this_row btn-sm btn-outline-warning">
                                <i style="color: blue" class="fas fa-edit" title="Edit"></i>
                            </button>
                            <button data-id="{{ $member->id }}" data-member_code="{{ $member->code }}"
                                style="background:none" class="btn delete_this_row btn-sm ">
                                <i style="color: red" class="fas fa-trash" title="Delete"></i>
                            </button>

                            <a href="{{ route('member.subscibe', $member->id) }}" style="background:none"
                                class="btn subscribe_btn btn-sm ">
                                <i style="color: green" class="fas fa-check-circle" title="Subscribe"> Subscribe</i>
                            </a>
                        </div>
                    </div>

                    <div class="expand-icon">
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="details-panel">
                        <div class="details-content">
                            <div class="details-left">
                                <div class="details-header">
                                    <img src="{{ asset('admin/uploads') . '/' . $member->photo }}"
                                        alt="{{ $member['name'] }}" class="details-avatar">
                                    <div class="details-title">
                                        <h3>{{ $member['name'] ?? 'Unknown' }}</h3>
                                        <p>
                                            @if (!empty($member['role']))
                                                {{ $member['role'] }}
                                                @if (!empty($member['department']))
                                                    • {{ $member['department'] }}
                                                @endif
                                            @elseif(!empty($member['department']))
                                                {{ $member['department'] }}
                                            @endif
                                        </p>
                                        <div class="social-links">
                                            <a href="https://twitter.com/" target="_blank"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a href="https://linkedin.com/in/" target="_blank"><i
                                                    class="fab fa-linkedin"></i></a>
                                            <a href="https://github.com/" target="_blank"><i class="fab fa-github"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-section">
                                    <h4><i class="fas fa-info-circle"></i> Information</h4>
                                    <div class="detail-item">
                                        <span class="detail-label">Join Date:</span>
                                        <span class="detail-value">{{ $joinDateDisplay }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Member Type:</span>
                                        <span class="detail-value">
                                            @if (!empty($member['memberType']))
                                                {{ ucfirst($member['memberType']) }}
                                            @else
                                                Member
                                            @endif
                                        </span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Status:</span>
                                        <span class="detail-value">{{ $member['status'] ?? 'Unknown' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="details-right">
                                <div class="detail-section">
                                    <h4><i class="fas fa-address-card"></i> Contact Details</h4>
                                    <div class="detail-item">
                                        <span class="detail-label">Email:</span>
                                        <span class="detail-value">{{ $member['email'] ?? 'Not available' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Phone:</span>
                                        <span class="detail-value">{{ $member['phone'] ?? 'Not available' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Address:</span>
                                        <span class="detail-value">{{ $member['address'] ?? 'Not available' }}</span>
                                    </div>
                                </div>

                                <div class="detail-section">
                                    <h4><i class="fas fa-user"></i> About</h4>
                                    <p style="color: #555; line-height: 1.6; margin-bottom: 20px;">
                                        {{ $member['bio'] ?? 'No biography available.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $data->links('pagination::default') }}
    </div>

    <!-- Add Member Modal -->
    <div class="modal" id="member-modal" style="align-items: center">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Add New Member</h2>
            </div>
            <div class="modal-body" id="member-modal-body">
                <form id="member-form">
                    <div style="text-align: center; margin-bottom: 20px; position: relative;">
                        <div class="avatar-container" id="avatarContainer">
                            <img id="avatar-preview" src="#" alt="Uploaded image" class="avatar-preview">
                            <input type="hidden" id="member-id">
                            <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" id="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Phone</label>
                            <input type="tel" name="phone" id="phone" class="form-control"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ old('address') }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="member-type">Status</label>
                            <select name="status" id="status">
                                <option value="">select</option>
                                <option @if (old('status') == 'active') selected="selected" @endif value="active">active
                                </option>
                                <option @if (old('status') == 'pending') selected="selected" @endif value="pending">
                                    pending</option>
                                <option @if (old('status') == 'suspended') selected="selected" @endif value="suspended">
                                    suspended</option>
                                <option @if (old('status') == 'expired') selected="selected" @endif value="expired">
                                    expired</option>
                                <option @if (old('status') == 'cancelled') selected="selected" @endif value="cancelled">
                                    cancelled</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="member-type">Gender</label>
                            <select name="gender" id="gender">
                                <option value="">select</option>
                                <option @if (old('gender') == 'male') selected="selected" @endif value="male">Male
                                </option>
                                <option @if (old('gender') == 'female') selected="selected" @endif value="female">Female
                                </option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Height (cm)</label>
                            <input type="number" step="0.01" name="height" id="height" class="form-control"
                                value="{{ old('height') }}">
                            @error('height')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control"
                                value="{{ old('weight') }}">
                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nationality</label>
                        <input name="nationality" id="nationality" class="form-control"
                            value="{{ old('nationality') }}">
                        @error('nationality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel modal-close" id="cancel-btn">Cancel</button>
                        <button type="submit" id="add_member" class="btn btn-save">Save Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div class="modal" id="edit-modal" style="align-items: center">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Edit Member Info</h2>
                <button class="close-btn modal-close" id="close-modal">&times;</button>
            </div>
            <div class="modal-body" id="edit-modal-body">
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/admin/js/uploadImage1.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Helper function to show notifications
            function showNotification(message, type) {
                $('.custom-notification').remove();

                var bgColor = type === 'success' ? '#28a745' : (type === 'warning' ? '#ffc107' : '#dc3545');
                var textColor = type === 'warning' ? '#333' : 'white';
                var icon = type === 'success' ? 'fa-check-circle' : (type === 'warning' ?
                    'fa-exclamation-triangle' : 'fa-times-circle');

                var notification = $(`
                    <div class="custom-notification ${type}" style="background: ${bgColor}; color: ${textColor};">
                        <i class="fas ${icon}" style="font-size: 1.2rem;"></i>
                        <div style="flex: 1;">${message}</div>
                        <button onclick="$(this).parent().remove()" style="background: none; border: none; color: ${textColor}; font-size: 1.2rem; cursor: pointer; margin-left: 10px;">&times;</button>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(function() {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // Close modal handlers
            $('.modal-close').click(function() {
                $(this).closest('.modal').modal('hide');
            });

            // Initialize click events
            initRowEvents();

            if (document.querySelectorAll('.member-row').length === 0) {
                const membersContainer = document.getElementById('members-container');
                membersContainer.innerHTML = `
                    <div style="padding: 40px; text-align: center; color: #95a5a6;">
                        <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px;"></i>
                        <h3>No members found</h3>
                        <p>There are no members in the directory yet.</p>
                    </div>
                `;
            }

            // Search functionality
            $(document).on('input', '#searchInput', function(e) {
                var name = $(this).val();
                jQuery.ajax({
                    url: '{{ route('member.search') }}',
                    type: 'post',
                    'dataType': 'html',
                    cache: false,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        name: name,
                    },
                    success: function(data) {
                        $("#members-container").html(data);
                        initRowEvents();
                    },
                    error: function() {
                        showNotification('Error searching members', 'error');
                    }
                });
            });

            // Validation function
            function validateMemberData(name, email, date_of_birth, gender, phone, height, weight, nationality,
                status, address) {
                // Name validation
                if (name == "") {
                    showNotification("Please enter the member name", 'error');
                    $('#name').focus();
                    return false;
                }
                if (name.length < 2) {
                    showNotification("Name must be at least 2 characters", 'error');
                    $('#name').focus();
                    return false;
                }
                if (name.length > 100) {
                    showNotification("Name cannot exceed 100 characters", 'error');
                    $('#name').focus();
                    return false;
                }
                var nameRegex = /^[a-zA-Z\s\.\-]+$/;
                if (!nameRegex.test(name)) {
                    showNotification("Name can only contain letters, spaces, dots, and hyphens", 'error');
                    $('#name').focus();
                    return false;
                }

                // Email validation
                if (email != "") {
                    var emailRegex = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
                    if (!emailRegex.test(email)) {
                        showNotification("Please enter a valid email address", 'error');
                        $('#email').focus();
                        return false;
                    }
                }

                // Date of birth validation
                if (date_of_birth == "") {
                    showNotification("Please enter the member date of birth", 'error');
                    $('#date_of_birth').focus();
                    return false;
                }
                var birthDate = new Date(date_of_birth);
                var today = new Date();
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 10) {
                    showNotification("Member must be at least 10 years old", 'error');
                    $('#date_of_birth').focus();
                    return false;
                }
                if (age > 120) {
                    showNotification("Please enter a valid date of birth", 'error');
                    $('#date_of_birth').focus();
                    return false;
                }

                // Gender validation
                if (gender == "") {
                    showNotification("Please select the member gender", 'error');
                    $('#gender').focus();
                    return false;
                }

                // Phone validation
                if (phone == "") {
                    showNotification("Please enter the member phone number", 'error');
                    $('#phone').focus();
                    return false;
                }
                var phoneDigits = phone.replace(/\D/g, '');
                if (phoneDigits.length < 8) {
                    showNotification("Phone number must be at least 8 digits", 'error');
                    $('#phone').focus();
                    return false;
                }
                if (phoneDigits.length > 15) {
                    showNotification("Phone number cannot exceed 15 digits", 'error');
                    $('#phone').focus();
                    return false;
                }

                // Height validation
                if (height != "") {
                    var heightNum = parseFloat(height);
                    if (isNaN(heightNum)) {
                        showNotification("Height must be a number", 'error');
                        $('#height').focus();
                        return false;
                    }
                    if (heightNum < 50 || heightNum > 300) {
                        showNotification("Height must be between 50 cm and 300 cm", 'error');
                        $('#height').focus();
                        return false;
                    }
                }

                // Weight validation
                if (weight != "") {
                    var weightNum = parseFloat(weight);
                    if (isNaN(weightNum)) {
                        showNotification("Weight must be a number", 'error');
                        $('#weight').focus();
                        return false;
                    }
                    if (weightNum < 10) {
                        showNotification("Weight cannot be less than 10 kg", 'error');
                        $('#weight').focus();
                        return false;
                    }
                    if (weightNum > 500) {
                        showNotification("Weight cannot exceed 500 kg", 'error');
                        $('#weight').focus();
                        return false;
                    }
                }

                // Nationality validation
                if (nationality == "") {
                    showNotification("Please enter the member nationality", 'error');
                    $('#nationality').focus();
                    return false;
                }
                if (nationality.length < 2) {
                    showNotification("Please enter a valid country name", 'error');
                    $('#nationality').focus();
                    return false;
                }

                // Status validation
                if (status == "") {
                    showNotification("Please select the member status", 'error');
                    $('#status').focus();
                    return false;
                }

                // Address warning (optional)
                if (address != "" && address.length < 5) {
                    showNotification("Address should be more specific (at least 5 characters)", 'warning');
                }

                return true;
            }

            // Add Member
            $(document).on('click', '#add_member', function(e) {
                e.preventDefault();

                var name = $('#name').val().trim();
                var email = $('#email').val().trim();
                var date_of_birth = $('#date_of_birth').val();
                var gender = $('#gender').val();
                var phone = $('#phone').val().trim();
                var height = $('#height').val();
                var weight = $('#weight').val();
                var nationality = $('#nationality').val().trim();
                var status = $('#status').val();
                var address = $('#address').val().trim();

                // Validate
                if (!validateMemberData(name, email, date_of_birth, gender, phone, height, weight,
                        nationality, status, address)) {
                    return false;
                }

                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('send_name_ajax', name);
                formData.append('send_phone_ajax', phone);
                formData.append('send_email_ajax', email);
                formData.append('send_date_of_birth_ajax', date_of_birth);
                formData.append('send_gender_ajax', gender);
                formData.append('send_nationality_ajax', nationality);
                formData.append('send_address_ajax', address);
                formData.append('send_height_ajax', height);
                formData.append('send_weight_ajax', weight);
                formData.append('send_status_ajax', status);

                var fileInput = $('#avatar-upload')[0];
                if (fileInput.files.length > 0) {
                    formData.append('item_img', fileInput.files[0]);
                }

                jQuery.ajax({
                    url: '{{ route('member.CheckExistsFirst') }}',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        send_name_ajax: name,
                        send_phone_ajax: phone,
                        send_email_ajax: email
                    },
                    success: function(data) {
                        var flagRes = true;
                        if (data == 'exists_before') {
                            var res = confirm(
                                'There is a previous member with these details. Would you like to continue?'
                            );
                            if (res != true) {
                                flagRes = false;
                            }
                        }
                        if (flagRes == true) {
                            $("#backup_freeze_modal").modal("show");
                            jQuery.ajax({
                                url: '{{ route('member.store') }}',
                                type: 'post',
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    setTimeout(function() {
                                        $("#backup_freeze_modal").modal(
                                            "hide");
                                    }, 1000);
                                    $('#searchInput').trigger('input');
                                    $('#close-modal').click();
                                    $('#member-form')[0].reset();
                                    $('#avatar-preview').attr('src', '#');
                                    showNotification("Member added successfully!",
                                        'success');
                                },
                                error: function(xhr, status, error) {
                                    setTimeout(() => {
                                        $("#backup_freeze_modal").modal(
                                            "hide");
                                    }, 1000);
                                    showNotification("Error: " + error, 'error');
                                    console.log(xhr.responseText);
                                }
                            });
                        }
                    },
                    error: function() {
                        showNotification("Error checking member existence", 'error');
                    }
                });
            });

            // Load edit row
            $(document).on('click', '.load_edit_this_row', function(e) {
                var id = $(this).data("id");
                var member_code = $(this).data("member_code");
                jQuery.ajax({
                    url: '{{ route('member.load_edit_row') }}',
                    type: 'post',
                    dataType: 'html',
                    cache: false,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        send_id_ajax: id,
                        send_member_code_ajax: member_code
                    },
                    success: function(data) {
                        $("#edit-modal-body").html(data);
                        $("#edit-modal").modal("show");
                        setTimeout(function() {
                            if (typeof initImageUpload === 'function') {
                                initImageUpload('edit-avatarContainer',
                                    'edit-avatar-preview', 'edit-avatar-upload');
                            }
                        }, 200);
                    },
                    error: function() {
                        showNotification("Error loading member data", 'error');
                    }
                });
            });

            // Update member
            $(document).on('click', '#to_update', function(e) {
                e.preventDefault();

                var name = $('#name_edit').val().trim();
                var email = $('#email_edit').val().trim();
                var date_of_birth = $('#date_of_birth_edit').val();
                var gender = $('#gender_edit').val();
                var phone = $('#phone_edit').val().trim();
                var height = $('#height_edit').val();
                var weight = $('#weight_edit').val();
                var nationality = $('#nationality_edit').val().trim();
                var status = $('#status_edit').val();
                var address = $('#address_edit').val().trim();

                // Validate
                if (!validateMemberData(name, email, date_of_birth, gender, phone, height, weight,
                        nationality, status, address)) {
                    return false;
                }

                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('send_code_ajax', $(this).data("member_code"));
                formData.append('send_id_ajax', $(this).data("id"));
                formData.append('send_name_ajax', name);
                formData.append('send_phone_ajax', phone);
                formData.append('send_email_ajax', email);
                formData.append('send_date_of_birth_ajax', date_of_birth);
                formData.append('send_gender_ajax', gender);
                formData.append('send_nationality_ajax', nationality);
                formData.append('send_address_ajax', address);
                formData.append('send_height_ajax', height);
                formData.append('send_weight_ajax', weight);
                formData.append('send_status_ajax', status);

                var fileInput = $('#edit-avatar-upload')[0];
                if (fileInput.files.length > 0) {
                    formData.append('item_img', fileInput.files[0]);
                }

                var submitBtn = $(this);
                var originalText = submitBtn.html();
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');

                jQuery.ajax({
                    url: '{{ route('member.update') }}',
                    type: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#backup_freeze_modal").modal("hide");
                        $('#searchInput').trigger('input');
                        $('#close-modal').click();
                        showNotification("Member updated successfully!", 'success');
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                    },
                    error: function(xhr, status, error) {
                        setTimeout(() => {
                            $("#backup_freeze_modal").modal("hide");
                        }, 1000);
                        showNotification("Error: " + error, 'error');
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                        console.log(xhr.responseText);
                    }
                });
            });

            // Delete member
            $(document).on('click', '.delete_this_row', function(e) {
                var res = confirm("Are you sure you want to delete this member?");
                if (!res) {
                    return false;
                }
                var id = $(this).data("id");
                var member_code = $(this).data("member_code");

                jQuery.ajax({
                    url: '{{ route('member.destroy') }}',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        send_id_ajax: id,
                        send_member_code_ajax: member_code
                    },
                    success: function(data) {
                        $('#searchInput').trigger('input');
                        showNotification("Member deleted successfully!", 'success');
                    },
                    error: function() {
                        showNotification("Error deleting member", 'error');
                    }
                });
            });
        });

        function initRowEvents() {
            const rows = document.querySelectorAll('.member-row');
            rows.forEach(row => {
                row.removeEventListener('click', row.clickHandler);
                row.clickHandler = function(e) {
                    if (e.target.tagName === 'A' || e.target.closest('a')) {
                        return;
                    }
                    const expandedRow = document.querySelector('.member-row.expanded');
                    if (this.classList.contains('expanded')) {
                        this.classList.remove('expanded');
                    } else {
                        if (expandedRow) {
                            expandedRow.classList.remove('expanded');
                        }
                        this.classList.add('expanded');
                        setTimeout(() => {
                            this.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }, 100);
                    }
                };
                row.addEventListener('click', row.clickHandler);
            });
        }

        document.addEventListener('keydown', (e) => {
            const expandedRow = document.querySelector('.member-row.expanded');
            if (expandedRow && e.key === 'Escape') {
                expandedRow.classList.remove('expanded');
            }
        });
    </script>
@endsection
