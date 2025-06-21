/**
 * DataTables Basic
 */

$(function () {
    'use strict';

    var dt_basic_table = $('.datatables-basic'),
      dt_date_table = $('.dt-date'),
      assetPath = window.location.href;

    // DataTable with buttons
    // --------------------------------------------------------------------

    if (dt_basic_table.length) {
      var dt_basic = dt_basic_table.DataTable({
        ajax: assetPath + '/list',
        columns: [
        //   { data: 'responsive_id' },
        //   { data: 'id' },
          { data: 'id' }, // used for sorting so will hide this column
          { data: 'name' },
          { data: 'email' },
          { data: 'phone' },
          { data: 'status' },
          { data: 'role' },
          { data: 'action' }
        ],
        columnDefs: [
            {
                targets: 0, // id
                render: function (data, type, full, meta) {
                    return full.id; // Directly render the id
                }
            },
            {
                targets: 1, // Name
                render: function (data, type, full, meta) {
                    return full.name; // Directly render the name
                }
            },
            {
                targets: 2, // Name
                render: function (data, type, full, meta) {
                    return full.email; // Directly render the name
                }
            },
             {
                targets: 3, // Name
                render: function (data, type, full, meta) {
                    return full.phone; // Directly render the name
                }
            },
            {
                targets: 4, // Status
                render: function (data, type, full, meta) {
                  // Checking if status is 1 (Active) or 0 (Inactive) and applying the appropriate badge class
                  if (full.status == "Active") {
                  return '<span class="badge badge-glow bg-success">Active</span>'; // Green badge for Active
                  } else {
                  return '<span class="badge badge-glow bg-danger">Inactive</span>'; // Red badge for Inactive
                  }
              }
            },
            {
                targets: 5, // Role
                render: function (data, type, full, meta) {
                    return '<span class="badge bg-info">' + full.role + '</span>';
                }
            },
            {
                // targets: 4, // Status
                // render: function (data, type, full, meta) {
                //     return full.status == 1 ? 'Active' : 'Inactive'; // Render status
                // }
                targets: 6, // Action column
                render: function (data, type, full, meta) {
                   
                    return (
                      '<div class="d-inline-flex">' +
                      '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                      feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                      '</a>' +
                      '<div class="dropdown-menu dropdown-menu-end">' +
                      // Conditionally display "Activate/Deactivate" based on the current status
                      '<a href="javascript:;" class="dropdown-item toggle-status" data-id="' + full.id + '" data-status="' + full.status + '">' +
                      feather.icons['archive'].toSvg({ class: 'font-small-4 me-50' }) +
                      (full.status ==  'Active' ? 'Deactivate' : 'Activate') +
                      '</a>' +
                      '<a href="javascript:;" class="dropdown-item delete-category" data-id="' + full.id + '">' +
                      feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                      'Delete</a>' +
                      '</div>' +
                      '</div>' +
                       // Edit button to trigger the modaldropdown-item modal-slide-in-edit
                    '<a href="javascript:;" class="item-edit modal-slide-in-edit" data-id="' + full.id + '" data-name="' + full.name + '" data-description="' + full.description + '" data-status="' + full.status + '">' +
                    feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                    '</a>'
                        );
                }
            }
        ],
        // order: [[2, 'desc']],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
          {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Category',
            className: 'create-new btn btn-primary',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
              $(node).removeClass('btn-secondary');
            }
          }
        ],
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return 'Details of ' + data['name'];
              }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
              var data = $.map(columns, function (col, i) {
                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                  ? '<tr data-dt-row="' +
                      col.rowIdx +
                      '" data-dt-column="' +
                      col.columnIndex +
                      '">' +
                      '<td>' +
                      col.title +
                      ':' +
                      '</td> ' +
                      '<td>' +
                      col.data +
                      '</td>' +
                      '</tr>'
                  : '';
              }).join('');

              return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
            }
          }
        },
        language: {
          paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
          }
        }
      });
      $('div.head-label').html('<h6 class="mb-0">List of Categories</h6>');
    }

    // Flat Date picker
    if (dt_date_table.length) {
      dt_date_table.flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'm/d/Y'
      });
    }

    // Add New record
    // ? Remove/Update this code as per your requirements ?
    var count = 101;
    // $('.data-submit').on('click', function () {
    //   var $new_name = $('.add-new-record .dt-full-name').val(),
    //     $new_post = $('.add-new-record .dt-post').val(),
    //     $new_email = $('.add-new-record .dt-email').val(),
    //     $new_date = $('.add-new-record .dt-date').val(),
    //     $new_salary = $('.add-new-record .dt-salary').val();

    //   if ($new_name != '') {
    //     dt_basic.row
    //       .add({
    //         id: count,
    //         name: $new_name,
    //         description: $new_post,
    //         status: $new_email,
    //       })
    //       .draw();
    //     count++;
    //     $('.modal').modal('hide');
    //   }
    // });

    // Delete Record

    $('.datatables-basic tbody').on('click', '.delete-record', function ()
    {
      dt_basic.row($(this).parents('tr')).remove().draw();
    });

    $('#store-user').on('submit', function (e) {

      e.preventDefault();
      // Clear previous error messages
      $('.invalid-feedback').text('').hide();
      $('.is-invalid').removeClass('is-invalid');
      // Get form action URL and initialize FormData
      const actionUrl = $(this).attr('action');
      const formData = new FormData(this);
      // Include CSRF token (important for Laravel)
      const csrfToken = $('meta[name="csrf-token"]').attr('content');
      formData.append('_token', csrfToken);
      // Send AJAX request
      $.ajax({
          url: actionUrl,
          type: 'POST',
          data: formData,
          processData: false, // Required for FormData
          contentType: false, // Required for FormData
          success: function (response) {
              console.log('response', response);
              if(response.success) {
                  // Hide the modal
                  $('#modals-slide-in').modal('hide');
                  // Optionally reload the page or update the table
                  alert(response.message);
                  location.reload();
              } else {
                  alert(response.message);
              }
          },
          error: function (xhr) {
              if (xhr.status === 422) {
                  // Validation errors
                  const errors = xhr.responseJSON.errors;
                  for (const [key, messages] of Object.entries(errors)) {
                      // Show error message
                      const keyName = key.includes('.') ? key.replace('.', '[').replace('.', ']') : key; // Handle nested fields
                      $(`.${keyName}-error`).text(messages[0]).show();
                      $(`[name="${keyName}"]`).addClass('is-invalid');
                  }
              } else {
                  alert('An unexpected error occurred.');
                  console.error(xhr);
              }
          }
      });
  });


  });
  // Edit Category

// $(document).on('click', '.modal-slide-in-edit', function () {
//   // Get data from the clicked edit button
//   const id          = $(this).data('id');
//   const name        = $(this).data('name');
//   const description = $(this).data('description');
//   const status      = $(this).data('status'); // Assuming 1 for Active, 0 for Inactive
//   // Populate the modal form with the category data
//   $('#edit-category-name').val(name);
//   $('#edit-category-description').val(description);

//   // Set the status radio button based on the category's status
//   if (status == 'Active')
//   {
//     $('#status').prop('checked', true);  // Check the checkbox
//   }
//   else
//   {
//     $('#status').prop('checked', false);  // Check the checkbox
//   }

//   // Store the status value in a hidden field or update the checkbox value attribute
//   // $('#status').val(status);

//   // Set the form's hidden category ID field
//   $('#edit-category-id').val(id);

//   // Show the modal
//   $('#modals-slide-in-edit').modal('show');
// });

$(document).on('click', '.modal-slide-in-edit', function () {

  var userId = $(this).data('id');
  // alert(userId);
  $.ajax({

      url: `/user/edit/${userId}`,

      method: 'GET',
      success: function (response)
      {

        $('#edit_name').val(response.user.name);
        $('#edit_email').val(response.user.email);
        $('#edit_phone').val(response.user.phone);
        $('#edit-user_id').val(response.user.id);

        $('#modals-slide-in-edit').modal('show');
      },
      error: function (error) {
          console.log('Error fetching data:', error);
          alert('Failed to load data.');
      }
  });

});

$('#update-user').on('submit', function (e) {
  e.preventDefault();
  // Clear previous error messages
  $('.invalid-feedback').text('').hide();
  $('.is-invalid').removeClass('is-invalid');

  // Get form action URL and initialize FormData
  const actionUrl = $(this).attr('action');
  const formData  = new FormData(this);
  // Include CSRF token (important for Laravel)
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
  formData.append('_token', csrfToken);

  // Send AJAX request
  $.ajax({
      url: actionUrl,
      type: 'POST',
      data: formData,
      processData: false, // Required for FormData
      contentType: false, // Required for FormData
      success: function (response)
      {
          // Hide the modal
          $('#modals-slide-in-edit').modal('hide');
          // Optionally reload the page or update the table
          alert('user Updated successfully!');
          location.reload();
      },
      error: function (xhr) {
          if (xhr.status === 422) {
              // Validation errors
              const errors = xhr.responseJSON.errors;
              for (const [key, messages] of Object.entries(errors)) {
                  // Show error message
                  const keyName = key.includes('.') ? key.replace('.', '[').replace('.', ']') : key; // Handle nested fields
                  $(`.${keyName}-error`).text(messages[0]).show();
                  $(`[name="${keyName}"]`).addClass('is-invalid');
              }
          } else {
              alert('An unexpected error occurred.');
              console.error(xhr);
          }
      }
  });

});

// Event listener for delete action
// Event listener for delete action
// Event listener for delete action
$(document).on('click', '.delete-category', function () {
  const userId = $(this).data('id');  // Get category ID from the button data attribute

  // Show confirmation prompt before deletion
  if (confirm('Are you sure you want to delete this category?')) {

      // Send the AJAX request to delete the category
      $.ajax({
          url: `/user/users/${userId}`,  // Correct URL with category prefix
          type: 'DELETE',  // HTTP method
          data: {
              _token: $('meta[name="csrf-token"]').attr('content')  // Include CSRF token
          },
          success: function (response) {
              // On success, reload or update the table data
              alert('Category deleted successfully');
              location.reload();  // Reload the page to reflect changes (you can also update the table dynamically)
          },
          error: function (error) {
              // Handle errors
              console.error('Error deleting category:', error);
              alert('There was an error deleting the category.');
          }
      });
  }
});

 // Change Status
//  $('.datatables-basic tbody').on('click', '.toggle-status', function ()
 $(document).on('click', '.toggle-status', function ()
 {

  const id     = $(this).data('id');  // Get category ID from the button data attribute
  const status = $(this).data('status');

  if (confirm('Are you sure you want to change the role of this record?')) {
      // Send the AJAX request
      $.ajax({
          url: `/user/change-status`,  // Correct URL with category prefix
          type: 'POST', // HTTP method
          contentType: 'application/json', // Specify JSON format
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
          },
          data: JSON.stringify({ // Convert the data to JSON string format
              id: id,
              status: status
          }),
          success: function (response)
          {
              alert('Status Changed Successfully!');
              location.reload();
          },
          error: function (xhr) {
              // Handle errors
              alert('Failed to change status of record. Please try again.');
              console.error(xhr.responseText);
          }
      });
  }
});

$(document).on('click', '.toggle-visible-status', function ()
{
 const id     = $(this).data('id');  // Get category ID from the button data attribute
 const status = $(this).data('status');
 if (confirm('Are you sure you want to show this category to Frontend?')) {
     // Send the AJAX request
     $.ajax({
         url: `/category/change-visibility`,  // Correct URL with category prefix
         type: 'POST', // HTTP method
         contentType: 'application/json', // Specify JSON format
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
         },
         data: JSON.stringify({ // Convert the data to JSON string format
             id: id,
             status: status
         }),
         success: function (response)
         {
             alert('Visibility Status Changed Successfully!');
             location.reload();
         },
         error: function (xhr) {
             // Handle errors
             alert('Failed to change status of record. Please try again.');
             console.error(xhr.responseText);
         }
     });
 }
});


