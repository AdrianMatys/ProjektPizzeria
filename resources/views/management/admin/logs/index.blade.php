@include('shared.header')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('admin.userName')}}</th>
                                    <th>{{__('admin.category')}}</th>
                                    <th>{{__('admin.type')}}</th>
                                    <th>{{__('admin.date')}}</th>
                                    <th>{{__('admin.details')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->user ? $log->user->email : '---' }}</td>
                                        <td>{{ $log->type->category->name }}</td>
                                        <td>{{ $log->type->name }}</td>
                                        <td>{{ $log->created_at }}</td>
                                        <td>
                                            <button onclick="toggleDetails(this)" class="btn btn-primary btn-sm" data-details-id="details-{{$log->id}}">
                                                {{__('admin.showDetails')}}
                                            </button>
                                            <div id="details-{{$log->id}}" class="details-modal" style="display: none;">
                                                <div class="details-modal-content">
                                                    <span class="close-btn" onclick="toggleDetails(document.querySelector('[data-details-id=\'details-{{$log->id}}\']'))">&times;</span>
                                                    <h2 class="details-title">{{__('admin.details')}}</h2>
                                                    
                                                    @if(is_array($log->details) || is_object($log->details))
                                                        @foreach ($log->details as $key => $value)
                                                            <div class="detail-item">
                                                                <div class="detail-label">{{ $key }}:</div>
                                                                @if (is_array($value))
                                                                    <div class="detail-value">
                                                                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                    </div>
                                                                @else
                                                                    <div class="detail-value">{{ $value }}</div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="detail-item">{{__('admin.noDetailsAvailable')}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
    background-image: url('https://i.pinimg.com/736x/f5/cc/5b/f5cc5b62458186c0e60d5981ce40e1cb.jpg');
    background-size: cover;
    background-attachment: scroll;
    font-family: 'Roboto', sans-serif;
}
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: #fff;
        border-collapse: collapse;
    }

    .table th {
        background-color: #f8f9fa;
        padding: 12px;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .table td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

     .btn-primary {
        background-color: #FF4500;
        color: #fff; 
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        background-color: #FF6347;
    }

    .btn-primary:active {
        background-color: #FF4500; 
        transform: translateY(1px); 
    }
    .table-responsive {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .details-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        min-width: 300px;
        max-width: 500px;
    }

    .details-modal-content {
        position: relative;
    }

    .close-btn {
        position: absolute;
        right: -10px;
        top: -10px;
        cursor: pointer;
        color: #FF4500;
        font-size: 20px;
    }

    .details-title {
        color: #FF4500;
        font-size: 1.5em;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #FFE4E1;
    }

    .detail-item {
        margin-bottom: 15px;
        padding: 5px 0;
    }

    .detail-label {
        font-weight: bold;
        color: #666;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #333;
    }

    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
</style>

<script>
function toggleDetails(button) {
    const detailsId = button.getAttribute('data-details-id');
    const detailsModal = document.getElementById(detailsId);
    const backdrop = document.querySelector('.modal-backdrop') || createBackdrop();
    
    if (detailsModal.style.display === 'none') {
        detailsModal.style.display = 'block';
        backdrop.style.display = 'block';
        button.classList.add('active');
    } else {
        detailsModal.style.display = 'none';
        backdrop.style.display = 'none';
        button.classList.remove('active');
    }
}

function createBackdrop() {
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop';
    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', () => {
        const openModals = document.querySelectorAll('.details-modal[style="display: block;"]');
        openModals.forEach(modal => {
            const button = document.querySelector(`[data-details-id="${modal.id}"]`);
            toggleDetails(button);
        });
    });
    return backdrop;
}
</script>