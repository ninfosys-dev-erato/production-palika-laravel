<x-layout.app>

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Form Sample</li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
                <div class="card">

                    <div class="d-flex justify-content-between card-header">
                        <h5>Default</h5>
                        <div>
                            <a href="#" class="btn btn-primary btn-md rounded"><i class="bx bx-list-ol"></i> List Data</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <x-form.text-input
                            label="Full Name"
                            id="fullName"
                            name="name"
                            value="John Doe"
                            class="custom-class"
                            placeholder="Enter your full name"
                            helper="Your full legal name"
                            type="text"
                            :required="true"
                            :disabled="false"
                            :readonly="false"
                            :autofocus="true"
                            :autocomplete="'name'"
                            :is-livewire="false"
                        />
                        <x-form.file-input
                            label="Upload Resume"
                            id="resume"
                            name="resume"
                            class="custom-file-class"
                            helper="Upload in PDF format"
                            :required="true"
                            :disabled="false"
                            :multiple="true"
                            accept=".pdf,.doc,.docx"
                            :is-livewire="false"
                        />
                        <x-form.select-input
                            label="Choose Country"
                            id="country"
                            name="country"
                            :options="['US' => 'United States', 'CA' => 'Canada', 'MX' => 'Mexico']"
                            :is-livewire="false"
                            selected="MX"
                            class="custom-select-class"
                            helper="Select your country"
                            placeholder="Select a country"
                            :required="true"
                            :disabled="false"
                            :multiple="false"
                        />
                        <x-form.radio-input
                            label="Gender"
                            id="gender"
                            name="gender"
                            :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']"
                            :is-livewire="false"
                            checked="female"
                            class="custom-radio-class"
                            helper="Select your gender"
                            :required="true"
                            :disabled="false"
                        />
                        <x-form.checkbox-input
                            label="Hobbies"
                            id="hobbies"
                            name="hobbies"
                            :options="['sports' => 'Sports', 'music' => 'Music', 'art' => 'Art']"
                            :is-livewire="false"
                            :checked="['sports', 'art']"
                            class="custom-checkbox-class"
                            helper="Select your hobbies"
                            :required="true"
                            :disabled="false"
                        />
                        <x-form.text-input
                            type="date"
                            label="Select Date"
                            :is-livewire="false"
                            id="datePicker"
                            name="date"
                        />

                        <x-form.text-input
                            type="datetime-local"
                            label="Select Date and Time"
                            :is-livewire="false"
                            id="dateTimePicker"
                            name="datetime"
                        />

                        <x-form.text-input
                            type="week"
                            label="Select Week"
                            :is-livewire="false"
                            id="weekPicker"
                            name="week"
                        />

                        <x-form.text-input
                            type="month"
                            label="Select Month"
                            :is-livewire="false"
                            id="monthPicker"
                            name="month"
                        />

                        <x-form.range-input
                            label="Select Range"
                            :is-livewire="false"
                            id="rangePicker"
                            name="range"
                            class="text-danger"
                        />

                        <x-form.textarea-input
                            label="Your Message"
                            :is-livewire="false"
                            id="message"
                            name="message"
                            rows="5"
                        />

                        {{--<x-form.ck-editor-input
                            label="Content"
                            :is-livewire="false"
                            id="ckeditor"
                            name="content"
                        />

                        <x-form.ck-editor-input
                            label="Content2"
                            :is-livewire="false"
                            id="ckeditor2"
                            name="content2"
                        />--}}


                    </div>
                </div>
            </div>



    </div>
</x-layout.app>
