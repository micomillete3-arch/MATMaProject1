(function (window, document) {
    if (!window.jQuery) {
        return;
    }

    function loadStudents() {
        window.jQuery.get('/students', function (data) {
            window.jQuery('#students_list').html(data);
        });
    }

    function loadTeachers() {
        window.jQuery.get('/teachers', function (data) {
            window.jQuery('#teachers_list').html(data);
        });
    }

    function loadDegrees() {
        window.jQuery.get('/degrees', function (data) {
            window.jQuery('#degrees_list').html(data);
        });
    }

    function startAutoLoad() {
        if (window.jQuery('#students_list').length) {
            loadStudents();
            setInterval(function () {
                loadStudents();
            }, 5000);
        }

        if (window.jQuery('#teachers_list').length) {
            loadTeachers();
            setInterval(function () {
                loadTeachers();
            }, 5000);
        }

        if (window.jQuery('#degrees_list').length) {
            loadDegrees();
            setInterval(function () {
                loadDegrees();
            }, 5000);
        }
    }

    function getErrorMessage(response, fallback) {
        let errors = response.responseJSON && response.responseJSON.errors;

        if (errors) {
            return Object.values(errors).flat().join('\n');
        }

        return response.responseJSON && response.responseJSON.message
            ? response.responseJSON.message
            : fallback;
    }

    window.jQuery(document).ready(function () {
        window.jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.jQuery('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        startAutoLoad();

        $('#saveStudent').click(function () {
            let fname = $('#fname').val();
            let lname = $('#lname').val();
            let email = $('#email').val();
            let contact_no = $('#contact_no').val();
            let degree_id = $('#degree_id').val();
            let username = $('#username').val();
            let password = $('#password').val();

            $('#student-create-panel').find('.field-error').removeClass('field-error');
            $('#student-create-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/students',
                type: 'POST',
                data: {
                    fname: fname,
                    lname: lname,
                    email: email,
                    contact_no: contact_no,
                    degree_id: degree_id,
                    username: username,
                    password: password
                },
                success: function () {
                    window.location.href = '/manageStudents';
                },
                error: function (response) {
                    alert(getErrorMessage(response, 'Please check the student form.'));
                    $('#saveStudent').prop('disabled', false);
                }
            });
        });

        $('#updateStudentBtn').click(function () {
            let studentId = $('#id').val();
            let fname = $('#f_name').val();
            let lname = $('#lname').val();
            let email = $('#email').val();
            let contact_no = $('#contact_no').val();
            let degree_id = $('#degree_id').val();
            let username = $('#username').val();
            let password = $('#password').val();

            $('#student-edit-panel').find('.field-error').removeClass('field-error');
            $('#student-edit-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/students/' + studentId,
                type: 'PUT',
                data: {
                    fname: fname,
                    lname: lname,
                    email: email,
                    contact_no: contact_no,
                    degree_id: degree_id,
                    username: username,
                    password: password
                },
                success: function (response) {
                    window.location.href = response.redirect_url || '/manageStudents';
                },
                error: function (response) {
                    alert(getErrorMessage(response, 'Please check the student form.'));
                    $('#updateStudentBtn').prop('disabled', false);
                }
            });
        });

        $('#saveTeacher').click(function () {
            let fname = $('#fname').val();
            let lname = $('#lname').val();
            let username = $('#username').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();

            $('#teacher-create-panel').find('.field-error').removeClass('field-error');
            $('#teacher-create-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/teachers',
                type: 'POST',
                data: {
                    fname: fname,
                    lname: lname,
                    username: username,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation
                },
                success: function () {
                    window.location.href = '/teachers';
                },
                error: function () {
                    alert('Please check the teacher form.');
                    $('#saveTeacher').prop('disabled', false);
                }
            });
        });

        $('#updateTeacherBtn').click(function () {
            let teacherId = $('#id').val();
            let fname = $('#f_name').val();
            let lname = $('#lname').val();
            let username = $('#username').val();
            let email = $('#email').val();
            let password = $('#password').val();

            $('#teacher-edit-panel').find('.field-error').removeClass('field-error');
            $('#teacher-edit-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/teachers/' + teacherId,
                type: 'PUT',
                data: {
                    fname: fname,
                    lname: lname,
                    username: username,
                    email: email,
                    password: password
                },
                success: function (response) {
                    window.location.href = response.redirect_url || '/teachers';
                },
                error: function () {
                    alert('Please check the teacher form.');
                    $('#updateTeacherBtn').prop('disabled', false);
                }
            });
        });

        $('#saveDegree').click(function () {
            let degree_name = $('#degree_name').val();

            $('#degree-create-panel').find('.field-error').removeClass('field-error');
            $('#degree-create-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/degrees',
                type: 'POST',
                data: {
                    degree_name: degree_name
                },
                success: function () {
                    window.location.href = '/degrees';
                },
                error: function () {
                    alert('Please check the degree form.');
                    $('#saveDegree').prop('disabled', false);
                }
            });
        });

        $('#updateDegreeBtn').click(function () {
            let degreeId = $('#id').val();
            let degree_name = $('#degree_name').val();

            $('#degree-edit-panel').find('.field-error').removeClass('field-error');
            $('#degree-edit-panel').find('[data-error-for]').text('');
            $(this).prop('disabled', true);

            window.jQuery.ajax({
                url: '/degrees/' + degreeId,
                type: 'PUT',
                data: {
                    degree_name: degree_name
                },
                success: function (response) {
                    window.location.href = response.redirect_url || '/degrees';
                },
                error: function () {
                    alert('Please check the degree form.');
                    $('#updateDegreeBtn').prop('disabled', false);
                }
            });
        });
    });

    function deleteStudent(id) {
        if (confirm('Delete this student?')) {
            $.ajax({
                url: '/students/' + id,
                type: 'DELETE',
                success: function () {
                    alert('Student deleted successfully!');
                    window.location.href = '/manageStudents';
                }
            });
        }
    }

    function deleteTeacher(id) {
        if (confirm('Delete this teacher?')) {
            $.ajax({
                url: '/teachers/' + id,
                type: 'DELETE',
                success: function () {
                    alert('Teacher deleted successfully!');
                    window.location.href = '/teachers';
                }
            });
        }
    }

    function deleteDegree(id) {
        if (confirm('Delete this degree?')) {
            $.ajax({
                url: '/degrees/' + id,
                type: 'DELETE',
                success: function () {
                    alert('Degree deleted successfully!');
                    window.location.href = '/degrees';
                }
            });
        }
    }

    window.deleteStudent = deleteStudent;
    window.deleteTeacher = deleteTeacher;
    window.deleteDegree = deleteDegree;
})(window, document);
