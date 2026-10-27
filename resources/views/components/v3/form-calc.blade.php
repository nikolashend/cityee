{{-- Price calculator form --}}
@props(['locale'])
@php
    $f = config("cityee-v3.forms.{$locale}");
@endphp

<section class="v3-form-section" id="v3-form-calc" aria-labelledby="v3-form-calc-title">
    <div class="container">
        <h2 id="v3-form-calc-title" class="v3-section-title">{{ $f['calc_title'] }}</h2>

        <form class="v3-form" data-v3-form="price-calculator" action="/contact/price-calculator" method="POST">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">

            <div class="v3-form__group">
                <label for="calc_address">{{ $f['calc_address'] }}</label>
                <input type="text" id="calc_address" name="address" required class="v3-form__input">
            </div>

            <div class="v3-form__row">
                <div class="v3-form__group v3-form__group--half">
                    <label for="calc_area">{{ $f['calc_area'] }}</label>
                    <input type="number" id="calc_area" name="area" min="1" class="v3-form__input">
                </div>
                <div class="v3-form__group v3-form__group--half">
                    <label for="calc_rooms">{{ $f['calc_rooms'] }}</label>
                    <input type="number" id="calc_rooms" name="rooms" min="1" max="20" class="v3-form__input">
                </div>
            </div>

            <div class="v3-form__group">
                <label for="calc_floor">{{ $f['calc_floor'] }}</label>
                <input type="text" id="calc_floor" name="floor" class="v3-form__input">
            </div>

            <div class="v3-form__group">
                <label for="calc_condition">{{ $f['calc_condition'] }}</label>
                <select id="calc_condition" name="condition" class="v3-form__input">
                    @foreach($f['calc_conditions'] as $cond)
                    <option value="{{ $cond }}">{{ $cond }}</option>
                    @endforeach
                </select>
            </div>

            {{-- One reachable channel: a phone OR an email. The server is the
                 authority (App\Rules\ReachableContact); type stays "text" so a
                 phone and an email can share the single `contact` field. --}}
            <div class="v3-form__group">
                <label for="calc_contact">{{ $f['calc_contact'] }}</label>
                <input type="text" id="calc_contact" name="contact" required
                       class="v3-form__input"
                       inputmode="text" autocomplete="tel email"
                       placeholder="{{ $f['calc_contact_ph'] ?? '' }}"
                       aria-describedby="calc_contact_error"
                       @error('contact') aria-invalid="true" @enderror>
                {{-- Filled by the shared handler when JS is on, and rendered
                     server-side after a redirect back when JS is off. --}}
                <p class="v3-form__error" id="calc_contact_error" data-error-for="contact"
                   style="{{ $errors->has('contact') ? '' : 'display:none;' }}"
                   role="alert">{{ $errors->first('contact') }}</p>
            </div>

            <button type="submit" class="v3-btn v3-btn--primary v3-btn--full">{{ $f['calc_submit'] }}</button>

            <p class="v3-form__success" style="display:none;" role="status">{{ $f['success_msg'] }}</p>
        </form>
    </div>
</section>
