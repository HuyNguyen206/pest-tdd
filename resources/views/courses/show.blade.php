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
    <a href="#"
       class="paddle_button"
       data-theme="light"
       data-items='[
    {
      "priceId": "{{$course->paddle_price_id}}",
      "quantity": 1
    }
  ]'><b>Buy now</b></a>


@section('scripts')
        <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
        <script type="text/javascript">
            @env('local')
            Paddle.Environment.set("sandbox");
            @endenv
            Paddle.Initialize({
                token: "{{config('services.paddle.client_key')}}" // replace with a client-side token
            });
            // let itemsList = [
            //     {
            //         priceId: "pri_01khfmtc7870b1bycs287xrf41",
            //         quantity: 1
            //     }
            // ];
            // // open checkout
            // function openCheckout(items){
            //     Paddle.Checkout.open({
            //         items: items
            //     });
            // }
        </script>
    @endsection

</x-guest-layout>

