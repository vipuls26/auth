<x-app-layout>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
        <table id="blog-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Id</th>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Content</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">user</th>
                    <th scope="col" class="px-6 py-3">created at</th>
                    <th scope="col" class="px-6 py-3">updated at</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
        </table>
    </div>


</x-app-layout>


<!-- jquery -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    data: 'status',
                    name: 'status'
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
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
