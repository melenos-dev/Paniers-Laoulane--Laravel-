@php
    echo '<li><a id="'.$child->id.'" href="'.route('productCat.index', array($child->id, $child->slug)).'">'.$child->name.'</a>';
@endphp

@if($childs = $child->descendants()->whereDepth(1)->orderBy('created_at', 'asc')->get())
    <ul>
    @foreach($childs as $child)
        @include('product.productCat.childs', ['child' => $child])
    @endforeach
    </ul>
@endif
</li>