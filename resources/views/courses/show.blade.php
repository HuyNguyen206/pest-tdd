<x-guest-layout>
    <h2>
        {{$course->title}}
    </h2>

    <p>{{$course->description}}</p>
    <p>{{$course->tagline}}</p>
    <ul>
        @foreach($course->learning ?? [] as $learn)
            <li>{{$learn}}</li>
        @endforeach
    </ul>
    <span>Total videos: {{$course->videos_count}} videos</span>
    <img src="{{asset($course->image)}}" alt="">
    <a href="#" onclick="openCheckout(itemsList)"><b>Sign up now</b></a>


@section('scripts')
        <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
        <script type="text/javascript">
            Paddle.Environment.set("sandbox");
            Paddle.Initialize({
                token: "{{config('services.paddle.client_key')}}" // replace with a client-side token
            });
            let itemsList = [
                {
                    priceId: "pri_01gsz8ntc6z7npqqp6j4ys0w1w",
                    quantity: 5
                },
                {
                    priceId: "pri_01h1vjfevh5etwq3rb416a23h2",
                    quantity: 1
                }
            ];
            // open checkout
            function openCheckout(items){
                Paddle.Checkout.open({
                    items: items
                });
            }
        </script>
    @endsection

</x-guest-layout>

