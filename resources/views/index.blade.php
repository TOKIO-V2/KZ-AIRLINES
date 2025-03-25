@extends ("layouts.app2")

@section ("content")
    <section class="bannerIndex mb-4">
        <div class="container d-flex flex-column justify-content-center" style="height: 20rem;">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('search') }}">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="departure" class="form-label">Departure:</label>
                                <input type="text" class="form-control" name="departure" value="" placeholder="Place for departure" autofocus>
                            </div>
                            <div class="col mb-3">
                                <label for="arrival" class="form-label">Arrival:</label>
                                <input type="text" class="form-control" name="arrival" value="" placeholder="Place for arrival" autofocus>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" autofocus>
                            </div>
                            <div class="col align-self-center">
                                <button type="submit" class="btn btn-warning w-100">
                                    {{ __('Search') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <h3 class="fs-2 text-center">Book Now!</h3>
	<div class="d-flex justify-content-center flex-wrap my-2">
        @for ($i = 0; $i < 8 && $i < $flights->count(); $i++)
            <div class="card m-2" style="width: 18rem;">
                <img src="{{asset('img/show.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="fs-3 card-title mb-4">{{$flights[$i]->arrival}}</h5>
                    <p class="card-text fs-5">{{$flights[$i]->date}}</p>
                    <a href="{{route('show', $flights[$i]->id)}}" class="btn btn-primary">See Details</a>
                </div>
            </div>
        @endfor
	</div>
    <h3 class="fs-2 text-center">Explore</h3>
    <div id="carouselExampleCaptions" class="carousel slide container mb-3">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('img/carousel1.jpg')}}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('img/carousel2.jpg')}}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('img/carousel3.jpg')}}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection