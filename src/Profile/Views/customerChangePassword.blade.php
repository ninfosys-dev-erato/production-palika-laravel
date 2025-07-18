<x-layout.customer-app header="Change Password">

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-6">
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start gap-2 align-items-sm-center gap-6 pb-4 border-bottom">
                        <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="user-avatar"
                            class="d-block w-px-100  rounded" id="uploadedAvatar">
                        <div>

                            <h5>{{ auth('customer')->user()->name }}</h5>
                            <h6>{{ auth('customer')->user()->email }}</h6>


                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 ">
                    <livewire:profile.customer_change_password_form />
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</x-layout.customer-app>
