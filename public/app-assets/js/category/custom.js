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
          { data: 'description' },
          { data: 'status' },
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
                targets: 2, // Description
                render: function (data, type, full, meta) {
                    return full.description; // Directly render the description
                }
            },
            {
                targets: 3, // Status
                render: function (data, type, full, meta) {
                    return full.status == 1 ? 'Active' : 'Inactive'; // Render status
                }
            },
            {
                targets: 4, // Status
                render: function (data, type, full, meta) {
                    return full.status == 1 ? 'Active' : 'Inactive'; // Render status
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
    $('.data-submit').on('click', function () {
      var $new_name = $('.add-new-record .dt-full-name').val(),
        $new_post = $('.add-new-record .dt-post').val(),
        $new_email = $('.add-new-record .dt-email').val(),
        $new_date = $('.add-new-record .dt-date').val(),
        $new_salary = $('.add-new-record .dt-salary').val();

      if ($new_name != '') {
        dt_basic.row
          .add({
            id: count,
            name: $new_name,
            description: $new_post,
            status: $new_email,
          })
          .draw();
        count++;
        $('.modal').modal('hide');
      }
    });

    // Delete Record
    $('.datatables-basic tbody').on('click', '.delete-record', function () {
      dt_basic.row($(this).parents('tr')).remove().draw();
    });
  });
