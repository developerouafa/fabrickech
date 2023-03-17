<x-mail::message>
# Couture Sofa

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

New Order, {{$user}} ---- Order Id : {{$pp}} --- quantity : {{$qty}} --- Total : ${{$total}}<br>
{{ config('app.name') }}
</x-mail::message>

{{-- | Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      | --}}
