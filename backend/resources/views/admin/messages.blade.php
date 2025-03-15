@extends('adminlte::page')

@section('title', 'Contact Messages')

@section('content_header')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Contact Messages</h1>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Message</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($messages as $message)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $message->id }}</td>
                            <td class="py-3 px-4">{{ $message->name }}</td>
                            <td class="py-3 px-4">{{ $message->email }}</td>
                            <td class="py-3 px-4">
                                <div class="max-w-xs overflow-hidden text-ellipsis">
                                    {{ Str::limit($message->message, 50) }}
                                    <button type="button" class="text-blue-500 hover:underline" 
                                        onclick="openMessageModal('{{ $message->id }}', '{{ $message->name }}', '{{ $message->email }}', '{{ addslashes($message->message) }}')">
                                        View
                                    </button>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($message->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                                @elseif($message->status == 'read')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Read</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Replied</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $message->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    @if($message->status == 'pending')
                                        <form action="{{ route('admin.messages.read', $message->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded-md text-xs">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($message->status != 'replied')
                                        <form action="{{ route('admin.messages.replied', $message->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 bg-green-500 text-white rounded-md text-xs">
                                                Mark as Replied
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded-md text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">No messages found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $messages->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Message Modal -->
    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Message Details</h2>
                <button onclick="closeMessageModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-500">From:</p>
                <p id="modalName" class="font-medium"></p>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-500">Email:</p>
                <p id="modalEmail" class="font-medium"></p>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Message:</p>
                <div id="modalMessage" class="mt-2 p-4 bg-gray-50 rounded-lg whitespace-pre-wrap"></div>
            </div>
            
            <div class="flex justify-between">
                <div>
                    <a id="replyEmailLink" href="#" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Reply via Email
                    </a>
                </div>
                <button onclick="closeMessageModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script>
        function openMessageModal(id, name, email, message) {
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('replyEmailLink').href = 'mailto:' + email;
            document.getElementById('messageModal').classList.remove('hidden');
        }
        
        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
@stop 
