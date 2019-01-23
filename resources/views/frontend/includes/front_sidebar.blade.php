<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        @foreach($categories as $category)
            @if($category->status == 1)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#{{$category->id}}" href="#{{$category->id}}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{$category->name}}
                        </a>
                    </h4>
                </div>
                <div id="{{$category->id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($category->categories as $subcategory)
                                @if($subcategory->status == 1)
                                <li><a href="{{route('products', $subcategory->slug)}}">{{$subcategory->name}}</a></li>
                                @endif
                                    @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div><!--/category-products-->





</div>