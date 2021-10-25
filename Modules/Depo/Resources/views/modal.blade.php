<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary">
          <h3 class="modal-title text-white" id="model-1"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close text-white"></i>
          </button>
        </div>
        <!-- /modal header -->
        <form id="store_or_update_form" method="post">
          @csrf
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="update_id" id="update_id"/>
                    <x-form.textbox labelName="Depo Name" name="name" required="required" col="col-md-6" placeholder="Enter warehouse name"/>
                    <x-form.textbox labelName="Mobile No." name="mobile_no" required="required" col="col-md-6" placeholder="Enter mobile number"/>
                    <x-form.textbox labelName="Email" type="email" name="email" col="col-md-6" placeholder="Enter email address"/>
                    <x-form.selectbox labelName="District" name="district_id" required="required" col="col-md-6" class="selectpicker">
                      @if (!$districts->isEmpty())
                          @foreach ($districts as $id => $name)
                              <option value="{{ $id }}">{{ $name }}</option>
                          @endforeach
                      @endif
                    </x-form.selectbox>
                    <x-form.textbox labelName="Commission Rate (%)" type="text" name="commission_rate" col="col-md-6" placeholder="Enter commission rate"/>
                    <x-form.textbox labelName="Previous Balance" name="previous_balance" col="col-md-6 pbalance d-none" class="text-right" placeholder="Previous balalnce"/>
                    <x-form.textarea labelName="Address" name="address" col="col-md-6" placeholder="Enter address"/>
                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
            </div>
            <!-- /modal footer -->
        </form>
      </div>
      <!-- /modal content -->

    </div>
  </div>