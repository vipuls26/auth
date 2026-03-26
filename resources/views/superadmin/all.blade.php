all user



<!-- <pre>{{ json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre> -->


<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">ID</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Updated At</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Roles</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Profile</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        @foreach($users as $user)
        <tr class="hover:bg-gray-50">
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->id }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->name }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->email }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->created_at }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->updated_at }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ $user->roles->first()->name }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{ ($user->image->image_path ?? 'profile/1774006004.jpg') }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">

                <a href="{{ $user->id }}/history"> History </a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
