<div class="card-body">
    <form action="{{ url()->current()}}" method="get">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <select name="sort_by"  class="form-control" id="">
                        <option selected disabled value="">Sort By</option>
                        <option value="id">Id</option>
                        <option value="name">Name</option>
                        <option value="created_at">created at</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <select name="order_by" class="form-control" id="">
                        <option selected disabled value="">Order By</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <select class="form-control" name="limit_by" id="">
                        <option selected disabled value="">Limit by</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <select class="form-control" name="status" id="">
                        <option selected disabled value="">Status</option>
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                    </select>
                </div>
            </div>
            <!-- Include Post Count Filter Only for Categories -->
            @if(isset($context) && $context === 'categories')
                <div class="col-3">
                    <div class="form-group">
                        <input type="number" name="post_count" class="form-control" placeholder="Min Posts Count">
                    </div>
                </div>
            @endif

            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search here...">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>
        </div>

    </form>
</div>
