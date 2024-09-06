<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag &amp; Drop</title>

    <!-- css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/drag.css">

</head>

<body>
    <h1>Drag &amp; Drop</h1>

    <!-- dropzone -->
    <p></p>
    <div id="dropzone" class="dropzone"></div>
    <button onclick="coba()">Simpan</button>
    <button onclick="showModal()">Buat Paket</button>

        <!-- Modal Buat Paket -->
        <div id="buatPaketModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Buat Paket</h2>
                <form id="namaPaketForm">
                    <div class="form-group">
                        <label for="namaPaket">Nama Paket:</label>
                        <input type="text" id="namaPaket" name="namaPaket">
                    </div>
                    <div class="form-group">
                        <label for="deskripsiPaket">Deskripsi:</label>
                        <textarea id="deskripsiPaket" name="deskripsiPaket"></textarea>
                    </div>
                    <button type="button" onclick="submitPaket()">Submit</button>
                </form>
            </div>
        </div>


    <hr>

    <!-- Part 3 -->
    @foreach ($dekors as $dekor)
    <div class="draggable itemA large-background" id="dekor-{{ $dekor->id }}">
        <img src="img/admin/gambarDekor/{{ $dekor->gambar }}" alt="Image A">
    </div>
    @endforeach

    @if (!$position->isEmpty())
        @foreach ($pecah as $item)
            @php
                $dekorPecah = explode(',', $item);
                $idDekor = str_replace('{', '', $dekorPecah[0]);
                $kiri = str_replace('', '', $dekorPecah[1]);
                $kanan = str_replace('}', '', $dekorPecah[2]);
            @endphp
        @endforeach

        @php
            $i = 0;
        @endphp
    @endif

    <script>
        let itemDrop = [];

        function coba() {
            var dropzone = document.getElementById('dropzone').getBoundingClientRect();
            var elemen = [];
            itemDrop.forEach(element => {
                elemen.push({
                    id: element,
                    el: document.getElementById(element)
                });
            });
            var posisi = elemen.reduce(function(result, item) {
                var rect = item.el.getBoundingClientRect();
                result.push(`{${item.id},${rect.top},${rect.left}}`);
                return result;
            }, []).join(',');

            var url = "http://127.0.0.1:8000/DragnDropAdmin/simpanDragnDrop?x=" + encodeURIComponent(posisi);
            window.open(url, '_self');
        }

        function showModal() {
            document.getElementById('buatPaketModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('buatPaketModal').style.display = "none";
        }

        function submitPaket() {
            var namaPaket = $('#namaPaket').val();
            var deskripsiPaket = $('#deskripsiPaket').val();
            var dropzone = document.getElementById('dropzone').getBoundingClientRect();
            var elemen = [];
            itemDrop.forEach(element => {
                elemen.push({
                    id: element,
                    el: document.getElementById(element)
                });
            });
            var posisi = elemen.reduce(function(result, item) {
                var rect = item.el.getBoundingClientRect();
                result.push(`${item.id}#${rect.top}#${rect.left}`);
                return result;
            }, []).join(',');

            var url = "http://127.0.0.1:8000/dragndroppaket?x=" + encodeURIComponent(posisi) + "&nama=" + encodeURIComponent(namaPaket) + "&deskripsi=" + encodeURIComponent(deskripsiPaket);
            window.open(url, '_self');
        }

        @if (!$position->isEmpty())
            @foreach ($pecah as $item)
                @php
                    $dekorPecah = explode(',', $item);
                    $idDekor = str_replace('{', '', $dekorPecah[0]);
                    $kiri = str_replace('', '', $dekorPecah[1]);
                    $kanan = str_replace('}', '', $dekorPecah[2]);
                @endphp

                document.getElementById('{{ $idDekor }}').style.position = "absolute";
                document.getElementById('{{ $idDekor }}').style.left = '{{ $kanan }}px';
                document.getElementById('{{ $idDekor }}').style.top = '{{ $kiri }}px';
            @endforeach
        @endif

        function reset() {
            @if (!$position->isEmpty())
                @foreach ($pecah as $item)
                    @php
                        $dekorPecah = explode(',', $item);
                        $idDekor = str_replace('{', '', $dekorPecah[0]);
                        $kiri = str_replace('', '', $dekorPecah[1]);
                        $kanan = str_replace('}', '', $dekorPecah[2]);
                    @endphp

                    document.getElementById('{{ $idDekor }}').style.position = "absolute";
                    document.getElementById('{{ $idDekor }}').style.left = '0px';
                @endforeach
            @endif
        }
    </script>

    <script src="js/drag.js"></script>
    <script src="https://unpkg.com/interactjs/dist/interact.min.js"></script>
</body>

</html>
