<select class="input w-full border border-gray-400" name="address" required>
    @if(old('address'))
        <option value="{{old('address')}}">{{old('address')}}</option>
    @endif
    <option value="">--- Select Barangay ---</option>
    <option value="Tabon-tabon">Tabon-tabon</option>
    <option value="San Agustin">San Agustin</option>
    <option value="San Juan">San Juan</option>
    <option value="Bacolod">Bacolod</option>
    <option value="San Julian">San Julian</option>
    <option value="San Pedro">San Pedro</option>
</select>