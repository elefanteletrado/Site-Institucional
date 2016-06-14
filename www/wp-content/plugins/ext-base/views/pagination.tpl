<nav class="text-center">
    <ul class="pagination">
        <li {class_prev}>
            <a href="{link_anterior}" aria-label="Anterior">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <!-- BEGIN PAGITEM -->
        <li {pag_atual}><a href="{link_pag}">{pag}</a></li>
        <!-- END PAGITEM -->
        <li {class_next}>
            <a href="{link_proxima}" aria-label="Próximo">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>