<x-app-layout>

    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg p-4 bg-white dark:bg-gray-800">

        <table id="blog-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Id</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Title</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Content</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Category</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">User</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Created At</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Updated At</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Status</th>
                </tr>
            </thead>
        </table>
    </div>

</x-app-layout>


<!-- toaster library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jquery -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- datatable cdn -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- script -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {


        $('#blog-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('blog.yajra-data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },

                {
                    data: 'created_at.date',
                    name: 'created_at',

                },
                {
                    data: 'updated_at.date',
                    name: 'updated_at'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $(document).on('change', '.status-dropdown', function() {

            let updateStatus = $(this).val();
            let blog_id = $(this).data('id');

            $.ajax({
                url: "/blog/" + blog_id + "/updateyajra",
                method: 'POST',
                data: {
                    id: blog_id,
                    status: updateStatus,
                    _token: ' {{ csrf_token() }}'
                },
                success: function(response) {
                    $('#blog-table').DataTable().ajax.reload(null, false);

                    if (response.success) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success(response.success);
                    } else {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "5000",
                        };

                        toastr.error(response.error);
                    }
                }
            });
        });
    });
</script>
