<div class="doctor-item" data-id="{{ $doctor->id }}">
    <div class="doctor-photo">
        <img class="profile-picture" src="{{ $doctor->profile_picture ? asset('storage/'.$doctor->profile_picture) : asset('images/none.png') }}" alt="{{ $doctor->full_name }}">
    </div>
    <div class="doctor-info">
        <h3>{{ $doctor->full_name }}</h3>
        <p>{{ $doctor->specialty ?: $doctor->specialization }}</p>
        <a href="{{ route('appointment.show', $doctor) }}" class="btn">Записаться на приём</a>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <button class="delete-doctor" data-id="{{ $doctor->id }}">Удалить</button>
        @endif
    </div>
</div> 