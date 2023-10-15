<div class="main-panel">
  <div class="content-wrapper">
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Order Requests</h4>
            <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
              <table class="table" id="orders-table">
                <thead>
                  <tr>
                    <th> Status </th>
                    <th> Order No. </th>
                    <th> Date Requested</th>
                    <th> Request Reviewed </th>
                    <th> Uploaded Image </th>
                    <th> Price </th>
                  </tr>
                </thead>
                <tbody>
                @if ($orders->isEmpty())
                          <tr>
                              <td colspan="11" class="text-center">
                                  <div class="order-info">No Pending Orders Available</div>
                              </td>
                          </tr>
                      @else
                  @foreach($orders as $key => $value)
                    <tr>
                      <td>
                          <?php if ($value->orderStatus == 1): ?>
                            <div class="badge badge-outline-warning">Awaiting Approval</div>
                          <?php elseif($value->orderStatus == 2): ?>
                            <form action="{{ route('cake-request.process', ['id' => $value->orderID]) }}" method="post"> 
                              @csrf
                              <button type="submit" class="badge badge-outline-success btn-success" style="text-decoration: none;">Pay Now</button>
                            </form>
                          <?php elseif($value->orderStatus == 3): ?>
                            <div class="badge badge-outline-danger">Rejected</div>
                          <?php elseif($value->orderStatus == 4): ?>
                            <div class="badge badge-outline-info">Paid</div>
                          <?php endif ?>
                      </td>
                      <td>
    <a href="#" class="btn" style="text-decoration: none; color: grey ;" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $value->orderID }}" onmouseover="this.style.color='red'" onmouseout="this.style.color='grey'">
        {{ $value->orderID }}
    </a>
</td>

                      <td>
                          {{ $value->created_at ? \Carbon\Carbon::parse($value->created_at)->format('d M Y') : '-' }}
                      </td>
                      <td>
                          {{ $value->updated_at ? \Carbon\Carbon::parse($value->updated_at)->format('d M Y') : '-' }}
                      </td>
                      <td>
                                @if (!empty($value->cakeOrderImage))
                                    <a href="{{ asset($value->cakeOrderImage) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-eye"></i>View Image</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!empty($value->cakePrice) && !is_null($value->cakePrice))
                                    &#8369; {{ number_format($value->cakePrice, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                    </tr>
                    <div class="modal fade" id="staticBackdrop{{ $value->orderID  }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Order No. {{ $value->orderID  }}</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  @if($value->isSelectionOrder == 2)
                                    <div align="center">
                                      <img src="{{ asset($value->cakeOrderImage) }}" style="max-width: auto;max-height: 250px;">
                                    </div>
                                  @endif
                                  <!-- details -->
                                  @if($value->isSelectionOrder == 1)
                                    <div class="card">
                                      <div class="card-body">
                                        <label>Size:</label>
                                          <span><i>{{ $value->cakeSize }}</i></span><br>
                                        <label>Flavor:</label>
                                          <span><i>{{ $value->cakeFlavor }}</i></span><br>
                                        <label>Filling:</label>
                                          <span><i>{{ $value->cakeFilling }}</i></span><br>
                                        <label>Icing:</label>
                                          <span><i>{{ $value->cakeIcing }}</i></span><br>
                                        <label>Top Border:</label>
                                          <span><i>{{ $value->cakeTopBorder }}</i></span><br>
                                        <label>Bottom Border:</label>
                                          <span><i>{{ $value->cakeBottomBorder }}</i></span><br>
                                        <label>Decoration:</label>
                                          <span><i>{{ $value->cakeDecoration }}</i></span><br>
                                        <label>Message:</label>
                                          <span><i>{{ $value->cakeMessage }}</i></span><br>
                                        <hr>
                                        <div align="right">
                                          <span>&#8369; {{ number_format($value->cakePrice, 2) }}</span>
                                        </div>
                                      </div>
                                    </div>
                                  @endif
                                  @if($value->isSelectionOrder == 2)
                                  <hr>
                                    <label>Info.:</label>
                                    <textarea class="form-control" rows="10" spellcheck="false" style="color:black;" readonly>{{ $value->cakeMessage  }}</textarea>
                                    @if($value->orderStatus == 2)
                                    <hr> 
                                      <label>Details:</label>
                                        <textarea class="form-control" name="invoice_details" rows="10" spellcheck="false" style="color:black;" readonly>{{ $value->invoice_details }}</textarea><br>
                                      <label>Product Price</label>
                                      <input type="text" class="form-control" value="&#8369; {{number_format($value->cakePrice, 2)}}" name="cakePrice" style="color: black;" readonly>
                                    @endif  

                                    @if($value->orderStatus == 3)
                                    <hr> 
                                      <label>Rejection Details:</label>
                                        <textarea class="form-control" name="rejection_details" rows="10" spellcheck="false" style="color:black;" readonly>{{ $value->invoice_details }}</textarea><br>
                                    @endif  

                                  @endif  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
                                </div>
                              </div>
                            </div>
                          </div>
                  @endforeach
                @endif 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
  <footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
      <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © iBake Tiers of Joy
      <?php echo date('Y');  ?><a href="{{route('terms')}}"> Terms</a> | <a href="{{route('privacy')}}">Privacy</a></span>
    </div>
  </footer>
  <!-- partial -->
</div>