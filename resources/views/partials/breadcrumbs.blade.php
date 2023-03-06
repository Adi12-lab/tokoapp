@unless ($breadcrumbs->isEmpty())
<div class="row pt-4 px-3">
  <ol class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
    
    @if (!is_null($breadcrumb->url) && $loop->first)
    <li class="breadcrumb-item first"><a href="{{ $breadcrumb->url }}" class="text-success">{{ $breadcrumb->title }}</a></li>
    
    @elseif($loop->last)
    <li class="breadcrumb-item active">{{ $breadcrumb->title}}</li>
    
    @else 
    <li class="breadcrumb-item"><a href="{{$breadcrumb->url}}" class="text-success">{{ $breadcrumb->title }}</a></li>
    @endif
    @endforeach
  </ol>
</div>
@endunless
