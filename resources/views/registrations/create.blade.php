@extends('layouts.app')
@section('title', 'Registrasi Baru')
@section('page-title', 'Form Registrasi Tamu')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p style="color:#999;font-size:.85rem;margin:0;">Isi semua data tamu dan informasi kamar dengan lengkap</p>
        </div>
        <a href="{{ route('registrations.index') }}" class="btn btn-outline-gold">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i><strong>Terdapat kesalahan input:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('registrations.store') }}" method="POST" id="regForm">
        @csrf

        <!-- Section 1: Room Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><span
                        style="background:linear-gradient(135deg,#C9A84C,#B8903E);color:#fff;width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:.8rem;margin-right:10px;">1</span>Informasi
                    Kamar</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                        <select class="form-select" id="room_type_filter" onchange="filterRooms()">
                            <option value="">-- Pilih Tipe Kamar --</option>
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type->id }}" data-price="{{ $type->price_per_night }}">
                                    {{ $type->name }} — Rp {{ number_format($type->price_per_night, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                        <select class="form-select" name="room_id" id="room_select" required>
                            <option value="">-- Pilih Kamar Tersedia --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" data-type="{{ $room->room_type_id }}"
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    Kamar {{ $room->room_number }} (Lt. {{ $room->floor }}) —
                                    {{ $room->roomType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah Tamu <span class="text-danger">*</span></label>
                        <input type="number" name="num_guests" class="form-control" min="1" max="10"
                            value="{{ old('num_guests', 1) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah Kamar <span class="text-danger">*</span></label>
                        <input type="number" name="num_rooms" class="form-control" min="1" max="10"
                            value="{{ old('num_rooms', 1) }}" required>
                    </div>

                    <!-- Price display -->
                    <div class="col-12">
                        <div id="price_info"
                            style="background:#FDFAF5;border:1.5px solid #EDE8DE;border-radius:10px;padding:16px;display:none;">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div style="font-size:.72rem;color:#999;text-transform:uppercase;letter-spacing:1px;">
                                        Tipe</div>
                                    <div style="font-weight:600;color:#1A1A2E;" id="info_type">—</div>
                                </div>
                                <div class="col-md-3">
                                    <div style="font-size:.72rem;color:#999;text-transform:uppercase;letter-spacing:1px;">
                                        Harga/Malam</div>
                                    <div style="font-weight:600;color:#C9A84C;" id="info_price">—</div>
                                </div>
                                <div class="col-md-3">
                                    <div style="font-size:.72rem;color:#999;text-transform:uppercase;letter-spacing:1px;">
                                        Jumlah Malam</div>
                                    <div style="font-weight:600;color:#1A1A2E;" id="info_nights">—</div>
                                </div>
                                <div class="col-md-3">
                                    <div style="font-size:.72rem;color:#999;text-transform:uppercase;letter-spacing:1px;">
                                        Total Estimasi</div>
                                    <div style="font-weight:700;color:#065F46;font-size:1.1rem;" id="info_total">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Stay Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><span
                        style="background:linear-gradient(135deg,#C9A84C,#B8903E);color:#fff;width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:.8rem;margin-right:10px;">2</span>Informasi
                    Menginap</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Check-in <span class="text-danger">*</span></label>
                        <input type="date" name="check_in_date" class="form-control" id="check_in_date"
                            value="{{ old('check_in_date', date('Y-m-d')) }}" required onchange="calcPrice()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Waktu Kedatangan <span class="text-danger">*</span></label>
                        <input type="time" name="arrival_time" class="form-control"
                            value="{{ old('arrival_time', '14:00') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Check-out <span class="text-danger">*</span></label>
                        <input type="date" name="check_out_date" class="form-control" id="check_out_date"
                            value="{{ old('check_out_date') }}" required onchange="calcPrice()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Keberangkatan</label>
                        <input type="date" name="departure_date" class="form-control"
                            value="{{ old('departure_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Resepsionis <span class="text-danger">*</span></label>
                        <select name="receptionist_id" class="form-select" required>
                            <option value="">-- Pilih Resepsionis --</option>
                            @foreach ($receptionists as $r)
                                <option value="{{ $r->id }}"
                                    {{ old('receptionist_id', auth()->id()) == $r->id ? 'selected' : '' }}>
                                    {{ $r->name }} ({{ $r->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. Kotak Deposit</label>
                        <input type="text" name="deposit_box_number" class="form-control"
                            value="{{ old('deposit_box_number') }}" placeholder="e.g. BOX-021">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Issued By</label>
                        <input type="text" name="issued_by" class="form-control"
                            value="{{ old('issued_by', auth()->user()->name) }}" placeholder="Nama penerbit">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Guest Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><span
                        style="background:linear-gradient(135deg,#C9A84C,#B8903E);color:#fff;width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:.8rem;margin-right:10px;">3</span>Data
                    Tamu</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                            placeholder="Nama sesuai KTP/Passport" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="occupation" class="form-control" value="{{ old('occupation') }}"
                            placeholder="e.g. Manager, Dokter">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Perusahaan/Instansi</label>
                        <input type="text" name="company" class="form-control" value="{{ old('company') }}"
                            placeholder="Nama perusahaan">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kebangsaan <span class="text-danger">*</span></label>
                        <select name="nationality" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Indonesia" {{ old('nationality') == 'Indonesia' ? 'selected' : '' }}>🇮🇩
                                Indonesia</option>
                            <option value="Malaysia" {{ old('nationality') == 'Malaysia' ? 'selected' : '' }}>🇲🇾
                                Malaysia</option>
                            <option value="Singapore" {{ old('nationality') == 'Singapore' ? 'selected' : '' }}>🇸🇬
                                Singapore</option>
                            <option value="Australia" {{ old('nationality') == 'Australia' ? 'selected' : '' }}>🇦🇺
                                Australia</option>
                            <option value="United States" {{ old('nationality') == 'United States' ? 'selected' : '' }}>
                                🇺🇸 United States</option>
                            <option value="United Kingdom" {{ old('nationality') == 'United Kingdom' ? 'selected' : '' }}>
                                🇬🇧 United Kingdom</option>
                            <option value="Japan" {{ old('nationality') == 'Japan' ? 'selected' : '' }}>🇯🇵 Japan
                            </option>
                            <option value="China" {{ old('nationality') == 'China' ? 'selected' : '' }}>🇨🇳 China
                            </option>
                            <option value="South Korea" {{ old('nationality') == 'South Korea' ? 'selected' : '' }}>🇰🇷
                                South Korea</option>
                            <option value="Netherlands" {{ old('nationality') == 'Netherlands' ? 'selected' : '' }}>🇳🇱
                                Netherlands</option>
                            <option value="Germany" {{ old('nationality') == 'Germany' ? 'selected' : '' }}>🇩🇪 Germany
                            </option>
                            <option value="France" {{ old('nationality') == 'France' ? 'selected' : '' }}>🇫🇷 France
                            </option>
                            <option value="India" {{ old('nationality') == 'India' ? 'selected' : '' }}>🇮🇳 India
                            </option>
                            <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. KTP</label>
                        <input type="text" name="id_card_number" class="form-control"
                            value="{{ old('id_card_number') }}" placeholder="16 digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. Passport</label>
                        <input type="text" name="passport_number" class="form-control"
                            value="{{ old('passport_number') }}" placeholder="A12345678">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" name="phone_number" class="form-control"
                            value="{{ old('phone_number') }}" placeholder="+62 812 3456 7890" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Member</label>
                        <input type="text" name="member_number" class="form-control"
                            value="{{ old('member_number') }}" placeholder="MBR-XXXX">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Jl. ....">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Permintaan khusus, alergi, dll.">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Pembayaran -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>
                    <span
                        style="
                background:linear-gradient(135deg,#C9A84C,#B8903E);
                color:#fff;
                width:28px;
                height:28px;
                border-radius:50%;
                display:inline-flex;
                align-items:center;
                justify-content:center;
                font-size:.8rem;
                margin-right:10px;
            ">4</span>
                    Informasi Pembayaran
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">

                    <!-- metode pembayaran -->
                    <div class="col-md-4">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" id="payment_method" onchange="toggleCard()">
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <!-- status -->
                    <div class="col-md-4">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-select">
                            <option value="unpaid">Belum Bayar</option>
                            <option value="paid">Sudah Bayar</option>
                            <option value="deposit">Deposit</option>
                        </select>
                    </div>

                </div>

                <!-- DATA CREDIT CARD -->
                <div id="credit_card_section" style="display:none; margin-top:20px;">
                    <hr>

                    <h6 style="color:#C9A84C;">Detail Credit Card</h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Card Number</label>
                            <input type="text" name="card_number" class="form-control"
                                placeholder="XXXX XXXX XXXX XXXX">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Card Holder Name</label>
                            <input type="text" name="card_holder_name" class="form-control"
                                placeholder="Nama Pemilik Kartu">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Expired Date</label>
                            <input type="month" name="card_expired" class="form-control">
                        </div>

                    </div>

                </div>

                <!-- DATA TRANSFER BANK -->
                <div id="transfer_section" style="display:none; margin-top:20px;">
                    <hr>
                    <h6 style="color:#C9A84C;">Detail Transfer Bank</h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="bank_name" class="form-control"
                                placeholder="Contoh: BCA / Mandiri">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_account_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" class="form-control">
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary"
                style="border-radius:8px;padding:11px 24px;">
                <i class="fas fa-times me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-gold" style="padding:11px 32px;font-size:.95rem;">
                <i class="fas fa-save me-2"></i> Simpan Registrasi
            </button>
        </div>

    </form>
@endsection


@push('scripts')
    <script>
        function toggleCard() {
            const method = document.getElementById('payment_method').value;

            const credit = document.getElementById('credit_card_section');
            const transfer = document.getElementById('transfer_section');

            credit.style.display = 'none';
            transfer.style.display = 'none';

            if (method === 'credit_card') {
                credit.style.display = 'block';
            }

            if (method === 'transfer') {
                transfer.style.display = 'block';
            }
        }

        function filterRooms() {
            const typeId = document.getElementById('room_type_filter').value;
            const select = document.getElementById('room_select');
        }

        function filterRooms() {
            const typeId = document.getElementById('room_type_filter').value;
            const select = document.getElementById('room_select');
            const opts = select.querySelectorAll('option');
            opts.forEach(opt => {
                if (!opt.value) return;
                opt.style.display = (!typeId || opt.dataset.type === typeId) ? '' : 'none';
            });
            select.value = '';
            calcPrice();
        }

        function calcPrice() {
            const typeSelect = document.getElementById('room_type_filter');
            const checkin = document.getElementById('check_in_date').value;
            const checkout = document.getElementById('check_out_date').value;
            const priceInfo = document.getElementById('price_info');
            const numRooms = parseInt(document.querySelector('[name=num_rooms]').value) || 1;

            if (!typeSelect.value || !checkin || !checkout) {
                priceInfo.style.display = 'none';
                return;
            }

            const selectedOption = typeSelect.options[typeSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const nights = Math.max(0, (new Date(checkout) - new Date(checkin)) / 86400000);

            if (nights <= 0) {
                priceInfo.style.display = 'none';
                return;
            }

            document.getElementById('info_type').textContent = selectedOption.text.split('—')[0].trim();
            document.getElementById('info_price').textContent = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('info_nights').textContent = nights + ' malam';
            document.getElementById('info_total').textContent = 'Rp ' + (price * nights * numRooms).toLocaleString('id-ID');
            priceInfo.style.display = 'block';
        }

        document.querySelector('[name=num_rooms]')?.addEventListener('input', calcPrice);
        document.getElementById('room_type_filter')?.addEventListener('change', calcPrice);
    </script>
@endpush
