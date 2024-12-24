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
            { data: 'id' },
            { data: 'name' },
            { data: 'phone' },
            { data: 'status' },
            { data: 'cnic_no' },
            { data: 'cnic_front_img' },
            { data: 'cnic_back_img' },
            { data: 'created_at' },
            { data: 'action' }
          ],
            createdRow: function (row, data, dataIndex) {
                // Add data-id attribute to the row
                $(row).attr('data-id', data.id);
            },
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
              targets: 2, // Phone
              render: function (data, type, full, meta) {
                return full.phone; // Directly render the phone number
              }
            },
            {
            targets: 3, // Status
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
              targets: 4, // CNIC number
              render: function (data, type, full, meta) {
                return full.cnic_no; // Render CNIC number
              }
            },
            {
              targets: 5, // CNIC front image
              render: function (data, type, full, meta) {
                return full.cnic_front_img ? `<img src="${full.cnic_front_img}" alt="CNIC Front" width="50" height="50">` : ''; // Render image or empty if not available
              }
            },
            {
              targets: 6, // CNIC back image
              render: function (data, type, full, meta) {
                return full.cnic_back_img ? `<img src="${full.cnic_back_img}" alt="CNIC Back" width="50" height="50">` : ''; // Render image or empty if not available
              }
            },
            {
              targets: 7, // Created at
              render: function (data, type, full, meta) {
                return full.created_at; // Render creation date
              }
            },
            {
              targets: 8, // Action column
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
                    (full.status == 'Active' ? 'Deactivate' : 'Activate') +
                    '</a>' +
                    '<a href="javascript:;" class="dropdown-item delete-record">' +
                    feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                    'Delete</a>' +
                    '</div>' +
                    '</div>' +
                    '<a href="javascript:;" class="item-edit">' +
                    feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                    '</a>'
                );
              }
            }
          ],
          dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 7,
          lengthMenu: [7, 10, 25, 50, 75, 100],
          buttons: [
            {
              text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Booking',
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
                  return col.title !== '' ? '<tr data-dt-row="' + col.rowIdx + '" data-dt-column="' + col.columnIndex + '">' +
                    '<td>' + col.title + ':' + '</td> ' +
                    '<td>' + col.data + '</td>' +
                    '</tr>' : '';
                }).join('');
                return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
              }
            }
          },
          language: {
            paginate: {
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });

        $('div.head-label').html('<h6 class="mb-0">List of Bookings</h6>');
    }

    // Flat Date picker
    if (dt_date_table.length) {
      dt_date_table.flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'm/d/Y'
      });
    }

    // Delete Record
    $('.datatables-basic tbody').on('click', '.delete-record', function () {
        // Get the row and retrieve the ID (assuming it's stored in a data attribute)
        const row = $(this).parents('tr');
        const id = row.data('id'); // Assuming the ID is stored as data-id in the row
        // Confirm before deleting
        if (confirm('Are you sure you want to delete this record?')) {
            // Send the AJAX request
            $.ajax({
                url: `${assetPath}/delete/${id}`, // Replace with your delete endpoint
                type: 'DELETE', // HTTP method
                contentType: 'application/json', // Specify JSON format
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
                },
                success: function (response) {
                    // Remove the row from DataTable
                    dt_basic.row(row).remove().draw();
                    alert('Record deleted successfully!');
                },
                error: function (xhr) {
                    // Handle errors
                    alert('Failed to delete record. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        }
    });
    // Change Status
    $('.datatables-basic tbody').on('click', '.toggle-status', function () {
        // Get the row and retrieve the ID (assuming it's stored in a data attribute)
        const row = $(this).parents('tr');
        const id = row.data('id'); // Assuming the ID is stored as data-id in the row
        const status = $(this).data('status');
        if (confirm('Are you sure you want to change the status of this record?')) {
            // Send the AJAX request
            $.ajax({
                url: `${assetPath}/change-status`, // Replace with your update endpoint
                type: 'POST', // HTTP method
                contentType: 'application/json', // Specify JSON format
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for Laravel
                },
                data: JSON.stringify({ // Convert the data to JSON string format
                    id: id,
                    status: status
                }),
                success: function (response) {
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
  });
    // Add New Booking
    // on submit of form
    $('#store-booking').on('submit', function (e) {
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

  // Edit Client
  $(document).on('click', '.modal-slide-in-edit', function () {
    // Get data from the clicked edit button
    const id = $(this).data('id');
    const name = $(this).data('name');
    const description = $(this).data('description');
    const status = $(this).data('status');
    // Populate the modal form with the category data
    $('#edit-category-name').val(name);
    $('#edit-category-description').val(description);

    // Set the status checkbox based on the category's status
    $('#edit-customSwitch').prop('checked', status === 1);
    $('#edit-customSwitch').val(status);

    // Set the form action to update the category
    $('#edit-category-id').val(id);

    // Show the modal
    $('#modals-slide-in-edit').modal('show');
});

// Event listener for delete action
$(document).on('click', '.delete-category', function () {
  const categoryId = $(this).data('id');  // Get category ID from the button data attribute

  // Show confirmation prompt before deletion
  if (confirm('Are you sure you want to delete this category?')) {

    alert("TES");
      // Send the AJAX request to delete the category
      $.ajax({
          url: `/category/categories/${categoryId}`,  // Correct URL with category prefix
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

let accountIndex = 1; // Tracks the number of account rows
// Add Account Button Click
$("#add-account-btn").on("click", function () {
    // Clone the hidden template and update it
    let template = $("#account-template").html();
    template = template.replace(/__INDEX__/g, accountIndex); // Replace placeholder with index
    // Convert the string to HTML and append to the wrapper
    const $newAccountRow = $(template);
    $("#account-details-wrapper").append($newAccountRow);
    // Increment the index
    accountIndex++;
});
// Remove Account Button Click
$("#account-details-wrapper").on("click", ".btn-remove-account", function () {
    $(this).closest(".account-detail").remove();
});
