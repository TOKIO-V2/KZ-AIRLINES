<footer class="footer">

    <div class="footer-links">
        <a href="{{ route('pastFlights') }}" class="btn btn-primary">Past Flights</a>
        @if(Auth::check() && Auth::user()->isAdmin)
            <a href="{{ route('planes') }}" class="btn btn-primary">Planes</a>
        @endif
        <a href="{{ route('flights') }}" class="btn btn-primary">New Flights</a>
    </div>
    <p>&copy; KZ AIRLINES</p>
    <a href="https://github.com/TOKIO-V2" target="_blank">GitHub</a>
</footer>