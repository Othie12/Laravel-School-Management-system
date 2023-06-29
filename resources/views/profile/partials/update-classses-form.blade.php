<section class="dark:bg-gray-800">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Classes for this teacher') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('The classes that are not checked are going to be removed from this teacher.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-classes') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mt-4">
            <h3 class="text-info">Classes currently taught by this teacher.</h3>
            <ul>
                @foreach ($teacherClasses as $class)
                    <li> {{ $class->name }} </li>
                @endforeach
            </ul>
        </div>

        <!-- classes -->
        <div class="mt-4">
            <x-input-label for="classes" :value="__('Choose classes you want to assign to this teacher')" />
            @foreach ($classes as $class)
                <input type="checkbox" name="classes[]" id="{{$class->name}}" value="{{ $class->id }}"> {{ $class->name }}<br>
            @endforeach
        </div>

        @if (Auth::user()->id !== $user->id)
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'ClassList-updated-succesfuly')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>

    </form>
</section>
