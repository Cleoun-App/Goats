
<span style="display: flex; justify-content: space-between; align-items: center">

    @if ($nav->hasPages())
        <nav class="tabulator">
            <div class="tabulator-footer mt-3">
                <span class="tabulator-paginator">
                    <select class="tabulator-page-size" aria-label="Page Size" title="Page Size"
                        wire:model.lazy="page_size" style="margin-bottom: 5px">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                    </select>
                </span>
            </div>
        </nav>
    @endif

    {{ $nav->links() }}

</span>