@if (@isset($data) and !@empty($data) and count($data) > 0)
    @foreach ($data as $member)
        @php
            // Determine status class
            $statusClass = 'status-' . strtolower($member['status'] ?? 'unknown');

            // Determine badge class
            $badgeClass = 'badge ' . ($member['memberType'] ?? 'member');

            // Format join date if exists
            $joinDateDisplay = 'N/A';
            if (!empty($member['joinDate'])) {
                try {
                    $joinDate = new DateTime($member['joinDate']);
                    $joinDateDisplay = $joinDate->format('F j, Y');
                } catch (Exception $e) {
                    $joinDateDisplay = $member['joinDate'];
                }
            }

            // Get notes if available (you can add this field to your database)
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
                    <button data-id="D" data-salary_employee_id="D" style="background:none" class="btn btn-sm ">
                        <i style="color: red" class="fas fa-trash" title="Delete"></i>
                    </button>
                </div>



            </div>

            <div class="expand-icon">
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="details-panel">
                <div class="details-content">
                    <!-- LEFT COLUMN -->
                    <div class="details-left">
                        <div class="details-header">
                            <img src="{{ $member['photo'] ?? 'https://via.placeholder.com/100' }}"
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

                                    <a href="https://twitter.com/" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>


                                    <a href="https://linkedin.com/in/" target="_blank">
                                        <i class="fab fa-linkedin"></i>
                                    </a>


                                    <a href="https://github.com/" target="_blank">
                                        <i class="fab fa-github"></i>
                                    </a>

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

                    <!-- RIGHT COLUMN -->
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

                        <!-- Notes Section (Added in the right column, second row) -->
                        {{-- <div class="notes-section">
                                    <h4><i class="fas fa-sticky-note"></i> Notes</h4>
                                    <div class="notes-content">
                                        {{ $notes }}
                                    </div>
                                </div> --}}
                    </div>
                </div>
            </div>


        </div>
    @endforeach
@else
    <p class="bg-danger text-center">No data found</p>
@endif
