@include('shared.header')

<style>
    
    .translations-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .page-title {
        color: #2d3748;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-left: 20px;
    }

    .page-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: #ff4d4d;
        border-radius: 2px;
    }

    .add-translation-btn {
        display: inline-block;
        background:#ff9800;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 25px;
        transition: all 0.3s ease;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .add-translation-btn:hover {
        background: #b46d02;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

   
    .translations-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .translations-table th {
        background: #4a5568;
        color: white;
        font-weight: 500;
        padding: 16px;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-align: left;
    }

    .translations-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
        font-size: 15px;
    }

    .translations-table tr:hover {
        background-color: #f7fafc;
    }

    .translations-table tr:last-child td {
        border-bottom: none;
    }
    .language-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin: 2px 4px;
        background: #ebf4ff;
        color: #4c51bf;
        border: 1px solid #c3dafe;
    }

    .details-btn {
        display: inline-block;
        padding: 8px 16px;
        background: #ff9800;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .details-btn:hover {
        background: #b46d02;
        transform: translateY(-1px);
    }
    @media (max-width: 768px) {
        .translations-container {
            padding: 0 15px;
            margin: 20px auto;
        }

        .page-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .translations-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .add-translation-btn {
            width: 100%;
            text-align: center;
        }
    }

    
    .modal-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f3f4f6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn-edit {
        background: #ff9800;
        color: white;
        border: none;
    }

    .modal-btn-edit:hover {
        background:rgb(158, 95, 0);
        transform: translateY(-1px);
    }

    .modal-btn-close {
        background: #e5e7eb;
        color: #4b5563;
        border: none;
    }

    .modal-btn-close:hover {
        background: #d1d5db;
    }


    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 450px; 
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease-out;
    }

    .modal-header {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f3f4f6;
    }

    .modal-title {
        color: #2d3748;
        font-size: 20px; 
        font-weight: 600;
    }

    .close-modal {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 24px; 
        font-weight: bold;
        color: #9ca3af;
        cursor: pointer;
        transition: color 0.2s;
    }

    .info-row {
        display: flex;
        padding: 8px 10px; 
        margin-bottom: 6px; 
        background: #f8fafc;
        border-radius: 6px;
        align-items: center;
    }

    .info-label {
        font-weight: 600;
        color: #4b5563;
        width: 120px; 
        flex-shrink: 0;
        font-size: 13px; 

    .info-value {
        color: #1f2937;
        flex-grow: 1;
        font-size: 13px; 
    }

    .modal-footer {
        margin-top: 15px; 
        padding-top: 15px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .modal-btn {
        padding: 8px 16px; 
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px; 
    }

    @media (max-width: 768px) {
        .modal-content {
            margin: 15% auto;
            width: 90%;
            padding: 15px;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            padding: 8px;
        }

        .info-label {
            margin-bottom: 4px;
            width: 100%;
        }
    }

   
    .edit-input {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 13px;
        transition: border-color 0.2s;
    }

    .edit-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
    }

    .edit-mode .info-value {
        display: none;
    }

    .view-mode .edit-input {
        display: none;
    }

    .language-select {
        width: 100%;
        padding: 6px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 13px;
        margin-top: 4px;
    }
</style>

<div class="translations-container">
    <h1 class="page-title">{{__('employee.translations')}}</h1>
    
    <button onclick="showAddModal()" class="add-translation-btn">
        {{__('employee.addNewTranslation')}}
    </button>

    <table class="translations-table">
        <thead>
            <tr>
                <th>{{__('employee.ingredientName')}}</th>
                <th>{{__('employee.availableLanguages')}}</th>
                <th>{{__('employee.details')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($translations as $translation)
                <tr>
                    <td>{{ $translation->ingredient->name }}</td>
                    <td>
                        @foreach($translation->ingredient->translations as $ingredientTranslation)
                            <span class="language-badge">
                                {{ $ingredientTranslation->language_code }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <button class="details-btn" onclick="showDetails(
                            '{{ $translation->id }}',
                            '{{ $translation->ingredient->name }}', 
                            '{{ $translation->ingredient->description }}', 
                            '{{ implode(', ', $translation->ingredient->translations->pluck('language_code')->toArray()) }}',
                            '{{ $translation->created_at }}',
                            '{{ $translation->updated_at }}',
                            '{{ route('management.employee.translations.edit', $translation->id) }}'
                        )">
                            {{__('employee.showDetails')}}
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div class="modal-header">
            <h2 class="modal-title">{{__('employee.translationDetails')}}</h2>
        </div>
        <form id="editForm" class="modal-body view-mode" action="{{ route('management.employee.translations.update', $translation) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden" id="translationId" name="id">
            <div class="info-row">
                <div class="info-label">{{__('employee.ingredientName')}}</div>
                <div class="info-value"></div>
                <input type="text" class="edit-input" name="name">
            </div>
            <div class="info-row">
                <div class="info-label">{{__('employee.description')}}</div>
                <input type="text" class="edit-input" name="description">
            </div>
            <div class="info-row">
                <div class="info-label">{{__('employee.availableLanguages')}}</div>
                <div class="info-value"></div>
                <select class="language-select edit-input" name="language_code">
                    <option value="en">{{__('employee.english')}}</option>
                    <option value="pl">{{__('employee.polish')}}</option>
                </select>
            </div>
            <button type="submit">{{__('employee.saveTranslation')}}</button>
        </form>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-edit" onclick="toggleEditMode()" id="editButton">
                {{__('employee.edit')}}
            </button>
            <button class="modal-btn modal-btn-save" onclick="saveChanges()" id="saveButton" style="display: none; background: #ff9800; color: white;">
                {{__('employee.saveChanges')}}
            </button>
            <button class="modal-btn modal-btn-close" onclick="closeModal()">
                {{__('employee.close')}}
            </button>
        </div>
    </div>
</div>

<!-- Add New Translation Modal -->
<div id="addTranslationModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeAddModal()">&times;</span>
        <div class="modal-header">
            <h2 class="modal-title">{{__('employee.addNewTranslation')}}</h2>
        </div>
        <form id="addTranslationForm" action="{{ route('management.employee.translations.store') }}" method="POST">
            @csrf
            <div class="info-row">
                <div class="info-label">{{__('employee.ingredientName')}}</div>
                <input type="text" class="edit-input" name="name" required>
            </div>
            <div class="info-row">
                <div class="info-label">{{__('employee.description')}}</div>
                <input type="text" class="edit-input" name="description" required>
            </div>
            <div class="info-row">
                <div class="info-label">{{__('navbar.language')}}</div>
                <select class="language-select edit-input" name="language_code" required>
                    <option value="en">{{__('navbar.english')}}</option>
                    <option value="pl">{{__('navbar.polish')}}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-btn modal-btn-edit">
                    {{__('employee.saveChanges')}}
                </button>
                <button type="button" class="modal-btn modal-btn-close" onclick="closeAddModal()">
                    {{__('client.cancel')}}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showDetails(id, name, description, languages) {
        const modal = document.getElementById('detailsModal');
        const form = document.getElementById('editForm');
        
       
        document.getElementById('translationId').value = id;
        form.querySelector('[name="name"]').value = name;
        form.querySelector('[name="description"]').value = description;
        
        
        const infoValues = form.querySelectorAll('.info-value');
        infoValues[0].textContent = name;
        infoValues[1].textContent = description;
        infoValues[2].textContent = languages;

       
        const languagesArray = languages.split(',').map(lang => lang.trim());
        const languageSelect = form.querySelector('[name="language_code"]');
        Array.from(languageSelect.options).forEach(option => {
            option.selected = languagesArray.includes(option.value);
        });
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        
        form.classList.remove('edit-mode');
        form.classList.add('view-mode');
        document.getElementById('editButton').style.display = 'block';
        document.getElementById('saveButton').style.display = 'none';
    }

    function toggleEditMode() {
        const form = document.getElementById('editForm');
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        
        form.classList.toggle('view-mode');
        form.classList.toggle('edit-mode');
        
        editButton.style.display = form.classList.contains('view-mode') ? 'block' : 'none';
        saveButton.style.display = form.classList.contains('edit-mode') ? 'block' : 'none';
    }

   

    function closeModal() {
        const modal = document.getElementById('detailsModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function showAddModal() {
        const modal = document.getElementById('addTranslationModal');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeAddModal() {
        const modal = document.getElementById('addTranslationModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('addTranslationForm').reset();
    }

    // Update the existing window.onclick handler
    window.onclick = function(event) {
        const detailsModal = document.getElementById('detailsModal');
        const addModal = document.getElementById('addTranslationModal');
        if (event.target == detailsModal) {
            closeModal();
        }
        if (event.target == addModal) {
            closeAddModal();
        }
    }

    // Update the existing escape key handler
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeAddModal();
        }
    });
</script>