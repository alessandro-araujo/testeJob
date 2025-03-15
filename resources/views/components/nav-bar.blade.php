<div>
    <nav class="bg-gray-900 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard.view') }}" class="text-2xl font-bold">TestFrellas</a>
            <ul class="hidden md:flex space-x-6">
                <li><a href="{{ route('dashboard.view') }}" class="hover:text-gray-400">Home</a></li>

                @can('check-student')
                    <li><a href="{{ route('student.view') }}" class="hover:text-gray-400">Link Teacher</a></li>
                    <li><a href="{{ route('student.reports') }}" class="hover:text-gray-400">School Report</a></li>
                @endcan

                @can('check-teacher')
                    <li><a href="{{ route('teacher.students') }}" class="hover:text-gray-400">Students Report</a></li>
                @endcan

                @can('check-admin')
                    <li><a href="{{ route('user.view') }}" class="hover:text-gray-400">Create Account</a></li>
                    <li><a href="{{ route('spreadsheet.view') }}" class="hover:text-gray-400">Upload Spreadsheet</a></li>
                    <li><a href="{{ route('spreadsheet.flag') }}" class="hover:text-gray-400">Flag Spreadsheet</a></li>
                    <li><a href="{{ route('student.check') }}" class="hover:text-gray-400">Check Students</a></li>
                @endcan

                <li><a href="{{ route('user.edit') }}" class="hover:text-gray-400">Edit Account</a></li>
                <li><a href="{{ route('login.destroy') }}"><img class="w-7 h-8" src="{{ asset('images/arrow.png') }}" alt="Descrição" /></a></li>

            </ul>
            <button class="md:hidden text-white focus:outline-none">☰</button>
        </div>
    </nav>
</div>
