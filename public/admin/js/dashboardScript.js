// admin/js/dashboardScript.js

// Sample Members Data
const membersData = [{
    id: 'GF1001',
    name: 'Michael Johnson',
    membership: 'Pro Plan',
    joinDate: '2023-05-15',
    status: 'active'
},
{
    id: 'GF1002',
    name: 'Sarah Roberts',
    membership: 'Elite Plan',
    joinDate: '2023-07-22',
    status: 'active'
},
{
    id: 'GF1003',
    name: 'David Wilson',
    membership: 'Basic Plan',
    joinDate: '2023-09-10',
    status: 'pending'
},
{
    id: 'GF1004',
    name: 'Emma Clark',
    membership: 'Pro Plan',
    joinDate: '2023-03-05',
    status: 'expired'
},
{
    id: 'GF1005',
    name: 'Thomas Brown',
    membership: 'Elite Plan',
    joinDate: '2023-11-18',
    status: 'active'
},
{
    id: 'GF1006',
    name: 'Lisa Anderson',
    membership: 'Pro Plan',
    joinDate: '2023-10-30',
    status: 'active'
},
{
    id: 'GF1007',
    name: 'Robert Garcia',
    membership: 'Basic Plan',
    joinDate: '2023-11-05',
    status: 'active'
},
{
    id: 'GF1008',
    name: 'Jennifer Lee',
    membership: 'Elite Plan',
    joinDate: '2023-08-14',
    status: 'active'
}
];

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainContent = document.getElementById('mainContent');
    const pageTitle = document.getElementById('pageTitle');
    const membersTable = document.getElementById('membersTable');
    const addMemberBtn = document.getElementById('addMemberBtn');
    const addMemberModal = document.getElementById('addMemberModal');
    const closeMemberModal = document.getElementById('closeMemberModal');
    const cancelMemberBtn = document.getElementById('cancelMemberBtn');
    const memberForm = document.getElementById('memberForm');
    const menuItems = document.querySelectorAll('.menu-item');
    const actionCards = document.querySelectorAll('.action-card');

    // Check if elements exist before adding event listeners
    if (toggleSidebarBtn) {
        // Toggle Sidebar
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');

            // Rotate toggle icon
            const icon = toggleSidebarBtn.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }

    if (mobileMenuBtn) {
        // Mobile Menu Toggle
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Menu Navigation
    if (menuItems.length > 0) {
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                if (item.getAttribute('href').startsWith('#')) {
                    e.preventDefault();

                    // Remove active class from all items
                    menuItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    item.classList.add('active');

                    // Update page title
                    const page = item.getAttribute('data-page');
                    updatePageTitle(page);

                    // Close mobile sidebar
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    }

    // Update Page Title
    function updatePageTitle(page) {
        const titles = {
            dashboard: {
                icon: 'fa-tachometer-alt',
                text: 'Dashboard'
            },
            members: {
                icon: 'fa-users',
                text: 'Member Management'
            },
            classes: {
                icon: 'fa-calendar-alt',
                text: 'Class Schedule'
            },
            attendance: {
                icon: 'fa-clipboard-check',
                text: 'Attendance Tracking'
            },
            payments: {
                icon: 'fa-credit-card',
                text: 'Payment Processing'
            },
            trainers: {
                icon: 'fa-user-tie',
                text: 'Trainer Management'
            },
            equipment: {
                icon: 'fa-dumbbell',
                text: 'Equipment Inventory'
            },
            reports: {
                icon: 'fa-chart-bar',
                text: 'Analytics & Reports'
            },
            settings: {
                icon: 'fa-cog',
                text: 'System Settings'
            }
        };

        if (titles[page] && pageTitle) {
            pageTitle.innerHTML = `<i class="fas ${titles[page].icon}"></i> ${titles[page].text}`;
        }
    }

    // Populate Members Table
    if (membersTable) {
        populateMembersTable();
    }

    function populateMembersTable() {
        membersTable.innerHTML = '';

        membersData.forEach(member => {
            const statusClass = `status-${member.status}`;
            const statusText = member.status.charAt(0).toUpperCase() + member.status.slice(1);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${member.id}</td>
                <td>
                    <div class="member-cell">
                        <div class="member-avatar">${member.name.split(' ').map(n => n[0]).join('')}</div>
                        <div>${member.name}</div>
                    </div>
                </td>
                <td>${member.membership}</td>
                <td>${member.joinDate}</td>
                <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                <td>
                    <button class="btn btn-accent btn-sm" onclick="viewMember('${member.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-warning btn-sm" onclick="editMember('${member.id}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteMember('${member.id}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            membersTable.appendChild(row);
        });
    }

    // Modal functionality
    if (addMemberBtn && addMemberModal) {
        // Add Member Modal
        addMemberBtn.addEventListener('click', () => {
            addMemberModal.classList.add('active');
            document.body.classList.add('modal-open'); // Prevent body scroll
        });
    }

    if (closeMemberModal && addMemberModal) {
        closeMemberModal.addEventListener('click', () => {
            addMemberModal.classList.remove('active');
            document.body.classList.remove('modal-open');
            if (memberForm) memberForm.reset();
        });
    }

    if (cancelMemberBtn && addMemberModal) {
        cancelMemberBtn.addEventListener('click', () => {
            addMemberModal.classList.remove('active');
            document.body.classList.remove('modal-open');
            if (memberForm) memberForm.reset();
        });
    }

    // Close modal when clicking outside
    if (addMemberModal) {
        addMemberModal.addEventListener('click', (e) => {
            if (e.target === addMemberModal) {
                addMemberModal.classList.remove('active');
                document.body.classList.remove('modal-open');
                if (memberForm) memberForm.reset();
            }
        });
    }

    // Form Submission
    if (memberForm) {
        memberForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Get form values
            const firstName = document.getElementById('firstName')?.value || '';
            const lastName = document.getElementById('lastName')?.value || '';
            const email = document.getElementById('email')?.value || '';
            const phone = document.getElementById('phone')?.value || '';
            const membershipType = document.getElementById('membershipType')?.value || '';
            const joinDate = document.getElementById('joinDate')?.value || '';

            // Generate new member ID
            const newId = 'GF' + (1000 + membersData.length + 1);

            // Add to members array
            membersData.unshift({
                id: newId,
                name: `${firstName} ${lastName}`,
                membership: membershipType === 'basic' ? 'Basic Plan' : membershipType === 'pro' ? 'Pro Plan' : 'Elite Plan',
                joinDate: joinDate,
                status: 'active'
            });

            // Update table
            if (membersTable) populateMembersTable();

            // Update stats
            updateStats();

            // Close modal and reset form
            addMemberModal.classList.remove('active');
            document.body.classList.remove('modal-open');
            memberForm.reset();

            // Show success message
            alert(`Member ${firstName} ${lastName} added successfully with ID: ${newId}`);
        });
    }

    // Quick Actions
    if (actionCards.length > 0) {
        actionCards.forEach(card => {
            card.addEventListener('click', () => {
                const action = card.getAttribute('data-action');

                switch (action) {
                    case 'checkin':
                        const memberId = prompt('Enter Member ID to check in:');
                        if (memberId) {
                            alert(`Member ${memberId} checked in successfully!`);
                        }
                        break;

                    case 'addClass':
                        alert('Opening class scheduling form...');
                        break;

                    case 'recordPayment':
                        alert('Opening payment recording form...');
                        break;

                    case 'sendNotification':
                        const message = prompt('Enter notification message to send to all members:');
                        if (message) {
                            alert(`Notification sent to all members: "${message}"`);
                        }
                        break;
                }
            });
        });
    }

    // Update Stats
    function updateStats() {
        const totalMembersEl = document.getElementById('totalMembers');
        const activeTodayEl = document.getElementById('activeToday');
        const monthlyRevenueEl = document.getElementById('monthlyRevenue');
        const attendanceRateEl = document.getElementById('attendanceRate');

        if (totalMembersEl) totalMembersEl.textContent = membersData.length;
        if (activeTodayEl) {
            const activeToday = Math.floor(40 + Math.random() * 20);
            activeTodayEl.textContent = activeToday;
        }
        if (monthlyRevenueEl) {
            const revenue = membersData.length * 40;
            monthlyRevenueEl.textContent = '$' + revenue.toLocaleString();
        }
        if (attendanceRateEl) {
            const attendanceRate = Math.floor(80 + Math.random() * 15);
            attendanceRateEl.textContent = attendanceRate + '%';
        }
    }

    // Refresh Stats Button
    document.querySelectorAll('.btn-refresh').forEach(btn => {
        btn.addEventListener('click', () => {
            const originalText = btn.innerHTML;

            // Show loading state
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                updateStats();

                // Show success
                btn.innerHTML = '<i class="fas fa-check"></i>';

                // Reset after 2 seconds
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            }, 1000);
        });
    });

    // View All Members Button
    const viewAllMembersBtn = document.getElementById('viewAllMembersBtn');
    if (viewAllMembersBtn) {
        viewAllMembersBtn.addEventListener('click', () => {
            // Switch to members page
            menuItems.forEach(i => i.classList.remove('active'));
            const membersMenuItem = document.querySelector('[data-page="members"]');
            if (membersMenuItem) membersMenuItem.classList.add('active');
            updatePageTitle('members');
        });
    }

    // Initialize the dashboard
    // Set today's date in join date field if it exists
    const joinDateField = document.getElementById('joinDate');
    if (joinDateField) {
        const today = new Date().toISOString().split('T')[0];
        joinDateField.value = today;
    }

    // Update stats
    updateStats();

   
});

// Global functions for member actions
window.viewMember = function(id) {
    alert(`Viewing member: ${id}\n\nThis would open a detailed view in a real application.`);
};

window.editMember = function(id) {
    alert(`Editing member: ${id}\n\nThis would open an edit form in a real application.`);
};

window.deleteMember = function(id) {
    if (confirm(`Are you sure you want to delete member ${id}?`)) {
        alert(`Member ${id} deleted.\n\nIn a real application, this would remove the member from the database.`);
        // In a real app: Remove from array and refresh table
        // const index = membersData.findIndex(m => m.id === id);
        // if (index > -1) {
        //     membersData.splice(index, 1);
        //     populateMembersTable();
        // }
    }
};