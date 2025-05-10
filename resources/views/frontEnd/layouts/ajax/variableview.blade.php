<div class="modal-view">
    <div class="variable-content">
        <button class="close-variable-button">
            <span></span>
            <span></span>
        </button>
        <div class="row">

            <div class="col-sm-12">
                @if ($productcolors->count() > 0)
                    <div class="pro-color">
                        <p class="color-title">Select Color </p>
                        <div class="color_inner">
                            <div class="size-container">
                                <div class="selector">
                                    @foreach ($productcolors as $key => $procolor)
                                        <div class="selector-item color-item" data-id="{{ $key }}">
                                            {{ $procolor->image }}
                                            <input type="radio" id="fc-option{{ $procolor->color }}"
                                                value="{{ $procolor->color }}" name="product_color"
                                                class="selector-item_radio  variable_color ajax-stock-check" required
                                                data-color="{{ $procolor->color }}" />
                                            <label for="fc-option{{ $procolor->color }}"
                                                class="selector-item_label">{{ $procolor->color }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($productsizes->count() > 0)
                    <div class="pro-size">
                        <p class="color-title">Select Size</p>
                        <div class="size_inner">

                            <div class="size-container">
                                <div class="selector">
                                    @foreach ($productsizes as $prosize)
                                        <div class="selector-item">
                                            <input type="radio" id="f-option{{ $prosize->size }}"
                                                value="{{ $prosize->size }}" name="product_size"
                                                class="selector-item_radio ajax-stock-check variable_size"
                                                data-size="{{ $prosize->size }}" required />
                                            <label for="f-option{{ $prosize->size }}"
                                                class="selector-item_label">{{ $prosize->size }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <button type="button" disabled id="variableSubmit" class="variable-submit" data-id="{{ $data->id }}">
                    Order Now   
                </button>
            </div>
        </div>
    </div>
</div>
