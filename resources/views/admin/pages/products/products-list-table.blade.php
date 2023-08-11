@foreach ($products as $product)
<tr id="product-{{ $product->id }}">
  <td class="product-name" data-toggle="modal" data-target="#productImageModal" data-imgPath="{{ $product->image }}">{{
    $product->name }}</td>
  <td>{{ $product->price }}</td>
  <td>{{ $product->category }}</td>
  <td>{{ $product->rating }}</td>
  <td>{{ $product->availability ? 'Available' : 'Unavailable' }}</td>
  {{-- <td><a href="#"><i class="mdi mdi-image-area product-img"></i></a></td> --}}
  <td>
    <a href="{{ route('admin.viewEditProducts', $product->id) }}">
      <button class="btn btn-md btn-inverse-success edit-product-btn">Edit</button>
    </a>
  </td>
  <td><button class="btn btn-md btn-inverse-danger delete-product-btn" 
  onclick="return confirm('Are you sure you want to delete this product?')"
  data-id="{{ $product->id }}" data-token="{{ csrf_token() }}">Delete</button></td>
  </td>
</tr>
@endforeach