<div class="overflow-x-auto w-full border border-gray-100 rounded-2xl bg-white shadow-sm">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50/70 border-b border-gray-100 font-bold">
            <tr>
                {{ $thead }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
