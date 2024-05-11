@props(['item'=>null,'size'=>120, 'float'=>''])

<img src="{{$item->image ? Storage::url('public/'.$item->image->url): asset('no-image.png')}}" class="{{$float}}" width="{{$size}}" style="border-radius: 10px">