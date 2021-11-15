<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">

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
                        <input type="hidden" name="update_id" id="update_id" />
                        <input type="hidden" name="warehouse_id" id="warehouse_id" value="1" />
                        <x-form.selectbox labelName="Dealer" name="dealer" required="required" col="col-md-12" class="selectpicker"
                            onchange="getUpazilaList(this.value,2)">
                            @if (!$dealers->isEmpty())
                            @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}" data-coaid="{{ $dealer->coa->id }}" data-name="{{ $dealer->name }}">{{ $dealer->name }}</option>
                            @endforeach
                            @endif
                        </x-form.selectbox>

                        <x-form.textbox labelName="Amount" name="amount" required="required" col="col-md-12" placeholder="Enter amount" />
                        <x-form.selectbox labelName="Payment Method" name="payment_method" required="required" col="col-md-12" class="selectpicker">
                            @foreach (PAYMENT_METHOD as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>
                        <x-form.selectbox labelName="Account" name="account_id" required="required" col="col-md-12"
                            class="selectpicker" />
                        <div class="form-group col-md-12 d-none reference_number">
                            <label for="reference_number">Reference No.</label>
                            <input type="text" class="form-control" name="reference_number" id="reference_number">
                        </div>
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