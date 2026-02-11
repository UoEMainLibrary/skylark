<div class="tab-heading">
    <div class="container">
        <p class="tab-p">The University of Edinburgh's rare and unique collections catalogue online.</p>
        <div class="form-group hidden-xs">
            <form action="{{ url('/redirect') }}" method="post">
                @csrf
                <div class="icon-addon addon-lg">
                    <div class="input-group-btn">
                        <input type="text" placeholder="Search the Collection Level Descriptions" class="form-control" name="q" id="q" >
                        <label class="glyphicon glyphicon-search" rel="tooltip"></label>
                        <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" title="Search the Collection Level Descriptions" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
