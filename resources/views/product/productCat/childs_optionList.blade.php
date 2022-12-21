<option value="{{ $child->id }}" {{($child->id == old('category_id')) || request()->route('id') == $child->id ? 'selected' : ''}}>{{$i.'> '.$child->name }}</option>
@if($childs = $child->descendants()->whereDepth(1)->orderBy('created_at', 'asc')->get())
    @foreach($childs as $child)
        @php 
            if($parent_id !=  $child->parent_id)
                $i.='--';
            $parent_id = $child->parent_id;
        @endphp
        @include('product.productCat.childs_optionList', ['child' => $child, 'i' => $i])
    @endforeach
@endif  