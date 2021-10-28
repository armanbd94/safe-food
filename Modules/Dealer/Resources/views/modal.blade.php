<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

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
        <form id="store_or_update_form" method="post" enctype="multipart/form-data">
          @csrf
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="update_id" id="update_id"/>
                    <x-form.textbox labelName="Dealer Name" name="name" required="required" col="col-md-6" placeholder="Enter name"/>
                    <x-form.textbox labelName="Mobile No." name="mobile_no" required="required" col="col-md-6" placeholder="Enter mobile number"/>
                    <x-form.textbox labelName="Email" name="email" col="col-md-6" placeholder="Enter email"/>
                    <x-form.textbox labelName="Commission Rate(%)" name="commission_rate" col="col-md-6" placeholder="Enter commission rate"/>
                    <x-form.textbox labelName="Previous Balance" name="previous_balance" col="col-md-6 pbalance d-none" class="text-right" placeholder="Previous balalnce"/>
                    <x-form.selectbox labelName="District" required="required" name="district_id" col="col-md-6" class="selectpicker" onchange="getUpazilaList(this.value,2)">
                        @if (!$districts->isEmpty())
                            @foreach ($districts as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        @endif
                    </x-form.selectbox>
                    <x-form.selectbox labelName="Upazila" required="required" name="upazila_id" col="col-md-6" class="selectpicker" onchange="getAreaList(this.value,2)"/>
                    <x-form.selectbox labelName="Area" required="required" name="area_id" col="col-md-6" class="selectpicker"/>
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