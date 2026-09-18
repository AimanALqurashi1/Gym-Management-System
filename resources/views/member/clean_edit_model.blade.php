<form id="edit_member-form">
    <div style="text-align: center; margin-bottom: 30px; position: relative;">
        <div class="avatar-container" id="edit-avatarContainer">
            <img id="edit-avatar-preview"
                src="{{ asset('admin/uploads') . '/' . ($data_row->photo ?? 'default-avatar.png') }}"
                alt="{{ $data_row['name'] }}" class="avatar-preview">
            <input type="file" id="edit-avatar-upload" name="item_img" accept="image/*" style="display: none;">
            <div class="upload-hint">
                <i class="fas fa-camera"></i> Click to change photo
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="name" id="name_edit" class="form-control" value="{{ $data_row['name'] }}"
                placeholder="Enter member name">
            @error('name')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" name="email" id="email_edit" class="form-control" value="{{ $data_row['email'] }}"
                placeholder="Enter email address">
            @error('email')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Phone Number</label>
            <input type="tel" name="phone" id="phone_edit" class="form-control" value="{{ $data_row['phone'] }}"
                oninput="this.value=this.value.replace(/[^0-9+]/g,'');" placeholder="Enter phone number">
            @error('phone')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar"></i> Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth_edit" class="form-control"
                value="{{ $data_row['date_of_birth'] }}">
            @error('date_of_birth')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label><i class="fas fa-map-marker-alt"></i> Address</label>
        <input type="text" name="address" id="address_edit" class="form-control" value="{{ $data_row['address'] }}"
            placeholder="Enter full address">
        @error('address')
            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="fas fa-toggle-on"></i> Status</label>
            <select name="status" id="status_edit" class="form-control">
                <option value="">Select Status</option>
                <option value="active" {{ $data_row['status'] == 'active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ $data_row['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="suspended" {{ $data_row['status'] == 'suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="expired" {{ $data_row['status'] == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="cancelled" {{ $data_row['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-venus-mars"></i> Gender</label>
            <select name="gender" id="gender_edit" class="form-control">
                <option value="">Select Gender</option>
                <option value="male" {{ $data_row['gender'] == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $data_row['gender'] == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="fas fa-arrow-up"></i> Height (cm)</label>
            <input type="number" name="height" id="height_edit" class="form-control"
                value="{{ $data_row['height'] }}" placeholder="Enter height" min="0" max="300"
                step="0.1">
            @error('height')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-weight"></i> Weight (kg)</label>
            <input type="number" name="weight" id="weight_edit" class="form-control"
                value="{{ $data_row['weight'] }}" placeholder="Enter weight" min="0" max="500"
                step="0.1">
            @error('weight')
                <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label><i class="fas fa-globe"></i> Nationality</label>
        <input type="text" name="nationality" id="nationality_edit" class="form-control"
            value="{{ $data_row['nationality'] }}" placeholder="Enter nationality">
        @error('nationality')
            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-danger modal-close" id="cancel-edit-btn">
            <i class="fas fa-times"></i> Cancel
        </button>
        <button type="submit" data-id="{{ $data_row->id }}" data-member_code="{{ $data_row->code }}"
            id="to_update" class="btn btn-success">
            <i class="fas fa-save"></i> Update Member
        </button>
    </div>
</form>

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize image upload for edit modal
            setTimeout(function() {
                if (typeof initImageUpload === 'function') {
                    initImageUpload('edit-avatarContainer', 'edit-avatar-preview', 'edit-avatar-upload');
                }
            }, 300);

            // Handle form submission
            $(document).on('click', '#to_update', function(e) {
                e.preventDefault();

                // Validation
                var name = $('#name_edit').val();
                if (name == "") {
                    showNotification('Please enter the member name', 'error');
                    $('#name_edit').focus();
                    return false;
                }

                var date_of_birth = $('#date_of_birth_edit').val();
                if (date_of_birth == "") {
                    showNotification('Please enter the date of birth', 'error');
                    $('#date_of_birth_edit').focus();
                    return false;
                }

                var gender = $('#gender_edit').val();
                if (gender == "") {
                    showNotification('Please select gender', 'error');
                    $('#gender_edit').focus();
                    return false;
                }

                var phone = $('#phone_edit').val();
                if (phone == "") {
                    showNotification('Please enter phone number', 'error');
                    $('#phone_edit').focus();
                    return false;
                }

                var status = $('#status_edit').val();
                if (status == "") {
                    showNotification('Please select status', 'error');
                    $('#status_edit').focus();
                    return false;
                }

                // Create FormData object for file upload
                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('send_code_ajax', $(this).data("member_code"));
                formData.append('send_id_ajax', $(this).data("id"));
                formData.append('send_name_ajax', name);
                formData.append('send_phone_ajax', phone);
                formData.append('send_email_ajax', $('#email_edit').val());
                formData.append('send_date_of_birth_ajax', date_of_birth);
                formData.append('send_gender_ajax', gender);
                formData.append('send_nationality_ajax', $('#nationality_edit').val());
                formData.append('send_address_ajax', $('#address_edit').val());
                formData.append('send_height_ajax', $('#height_edit').val());
                formData.append('send_weight_ajax', $('#weight_edit').val());
                formData.append('send_status_ajax', status);

                // Handle photo upload
                var fileInput = $('#edit-avatar-upload')[0];
                if (fileInput.files.length > 0) {
                    formData.append('item_img', fileInput.files[0]);
                }

                // Show loading state
                var submitBtn = $(this);
                var originalText = submitBtn.html();
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');

                $.ajax({
                    url: '{{ route('member.update') }}',
                    type: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        showNotification('Member updated successfully!', 'success');

                        // Close modal
                        $('#edit-modal').removeClass('active');

                        // Refresh member list
                        $('#searchInput').trigger('input');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        showNotification('Error: ' + (xhr.responseJSON?.message ||
                            'Something went wrong'), 'error');

                        // Reset button
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                    }
                });
            });

            // Close modal handlers
            $(document).on('click', '.modal-close', function() {
                $(this).closest('.modal').removeClass('active');
            });

            $(document).on('click', '.modal', function(e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).removeClass('active');
                }
            });

            // Notification function
            function showNotification(message, type) {
                // You can replace this with a toast notification or styled alert
                if (type === 'success') {
                    alert('✅ ' + message);
                } else {
                    alert('❌ ' + message);
                }
            }
        });
    </script>
@endsection
