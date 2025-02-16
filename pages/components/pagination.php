<div class="d-flex justify-content-end">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item "><a class="page-link toggle-loader <?= $response->_page == 1 ? 'disabled' : '' ?>" href="<?= Response::changeUrlParams(['_page' => $response->_page - 1])?>">Previous</a></li>
            <li class="page-item">
                <form action="" method="get">
                    <div class="input-group rounded-0 text-center" style="max-width: 120px">
                        <label for="" class="input-group-text rounded-0 text-center">Page</label>
                        <input class="form-control rounded-0 text-center" min="1" type="number" name="_page" required value="<?=$response->_page?>">
                    </div>
                </form>
            </li>
            <li class="page-item "><a class="page-link toggle-loader" href="<?= Response::changeUrlParams(['_page' => $response->_page + 1])?>">Next</a></li>
        </ul>
    </nav>
</div>