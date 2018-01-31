<div class="wrap">
    <h1>Procedura di creazione del nuovo evento padre</h1>

    <form method="post" action="">
        <h4>Attività da svolgere prima di creare un nuovo Evento padre:</h4>
        <div>
            <ol>
                <li>
                    Sviluppare il master del template per la staticizzazione di <i>header.php</i> e  <i>footer.php</i>
                    <ol>
                        <li>il nome del file deve essere <strong>b2b_price_conf_#id-sito#.shtml</strong></li>
                    </ol>
                </li>
                <li>
                    Sviluppare il tema per wordpress
                    <ol>
                        <li>Il nome de tema deve essere <strong>b2b-price-conf_#id-sito#</strong></li>
                        <li>Ricordati che i file <i>header.php</i> e <i>footer.php</i> sono creati dinamicamente dal sistema di staticizzazione</li>
                        <li>E' possibile clonare un tema già esistente ma usare il nome del template corretto (eventi "Cibo a Regola d'arte")</li>
                    </ol>
                </li>
                <li>
                    Accedere nel sistema di staticizzazione in <a href="/wp-admin/network/site-new.php" target="_blank">Amministrazione del network › Temi › Staticizzazione</a>
                    <ol>
                        <li>cliccare sul tasto <strong>Staticizzazione Manuale</strong></li>
                        <li>Verificare che non ci siano errori</li>
                        <li style="color:#990000">NON FUNZIONA PER PROBLEMI AI DIRITTI DI SCRITTURA (2018-01-25)</li>
                    </ol>
                </li>

            </ol>
        </div>
        <h4>Attività da svolgere per l'attivazione di un nuovo sito per Evento Padre</h4>
        <div>
            <ol>
                <li>Accedere <a href="/wp-admin/network/site-new.php" target="_blank">Siti › Aggiungi nuovo</a></li>
                <li>Accedere nella bacheca del sito appena creato</li>
                <li>
                    Accedere in <strong>Impostazioni › Generali</strong>
                    <ol>
                        <li>Controllare il campo <strong>Titolo sito</strong></li>
                        <li>Cancellare il contenuto del campo <strong>Motto</strong></li>
                        <li>Verifica l'indirizzo email</li>
                    </ol>
                </li>
                <li>
                    Accedere in <strong>Impostazioni › Lettura</strong>
                    <ol>
                        <li>Controllare il campo <strong>Visibilità ai motori di ricerca</strong> prima della
                            pubblicazione va tolto il check
                        </li>
                    </ol>
                </li>
                <li>
                    Accedere in <strong>Impostazioni › Discussione</strong>
                    <ol>
                        <li>Mettere il flag sul campo <strong>Gli utenti devono essere registrati e fare il login per
                                poter inviare commenti</strong></li>
                        <li>Mettere il flag sul campo <strong> Il commento deve essere approvato manualmente </strong></li>
                    </ol>
                </li>
                <li>
                    Accedere in <strong>Impostazioni › Permalink</strong>
                    <ol>
                        <li>Usare l'impostazione <strong>Nome articolo</strong></li>
                    </ol>
                </li>
                <li>
                    Accedere in <strong>Impostazioni › Admin Columns › Settings</strong>
                    <ol>
                        <li>togli il flag da <strong>Show "Modifica colonne" button on table screen. Default is on.</strong></li>
                    </ol>
                </li>
            </ol>
        </div>
    </form>
</div>