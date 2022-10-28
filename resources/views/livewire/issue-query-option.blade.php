<div>
    <table class="table table-sm table-borderless">
        <tbody>
            <tr class="align-middle">
                <td>{{ __('Items') }}</td>
                <td>
                    <span class="query-columns">
                        <span>
                            <label for="available-items">{{ __('Available items') }}</label>
                            <select id="available-items" size="10" multiple wire:model="available_selected">
                                @foreach($available_items as $available_item)
                                    <option value="{{ $available_item }}">{{ __($available_item) }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="buttons">
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clickAddItem"><i class="bi bi-arrow-right"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clickRemoveItem"><i class="bi bi-arrow-left"></i></button>
                        </span>
                        <span>
                            <label for="selected-items">{{ __('Selected Items') }}</label>
                            <select id="selected-items" name="q[]" size="10" multiple wire:model="selected">
                                @foreach($selected_items as $selected_item)
                                    <option value="{{ $selected_item }}">{{ __($selected_item) }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="buttons">
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clickItemUp"><i class="bi bi-arrow-up"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="clickItemDown"><i class="bi bi-arrow-down"></i></button>
                        </span>
                    </span>
                    <script>
                        document.addEventListener('DOMContentLoaded', function(){
                            document.querySelector('#selected-items').closest('form').addEventListener('submit', (event)=> {
                                document.querySelectorAll('#selected-items option:not(:disabled)').forEach(element => {
                                    element.selected = true;
                                });
                            })
                        });
                    </script>
                </td>
            </tr>
        </tbody>
    </table>
</div>
