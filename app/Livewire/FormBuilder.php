<?php

namespace App\Livewire;

use App\Models\Form;
use Illuminate\Support\Str;
use Livewire\Component;

class FormBuilder extends Component
{
    public ?int $formId = null;
    public string $title = 'Untitled Form';
    public string $description = '';
    public array $fields = [];
    public ?int $activeFieldIndex = null;
    public bool $showSaveNotification = false;
    public bool $isDirty = false;

    // Active field editing properties
    public string $editLabel = '';
    public string $editPlaceholder = '';
    public bool $editRequired = false;
    public string $editOptions = '';

    protected $listeners = [
        'reorderFields',
        'fieldDropped',
    ];

    public function mount(?int $formId = null): void
    {
        if ($formId) {
            $form = Form::where('user_id', auth()->id())->findOrFail($formId);
            $this->formId = $form->id;
            $this->title = $form->title;
            $this->description = $form->description ?? '';
            $this->fields = $form->schema['fields'] ?? [];
        }
    }

    /**
     * Available field types for the palette.
     */
    public function getFieldTypesProperty(): array
    {
        return [
            ['type' => 'text', 'label' => 'Text Input', 'icon' => 'text', 'group' => 'basic'],
            ['type' => 'email', 'label' => 'Email', 'icon' => 'email', 'group' => 'basic'],
            ['type' => 'number', 'label' => 'Number', 'icon' => 'number', 'group' => 'basic'],
            ['type' => 'phone', 'label' => 'Phone', 'icon' => 'phone', 'group' => 'basic'],
            ['type' => 'url', 'label' => 'URL', 'icon' => 'url', 'group' => 'basic'],
            ['type' => 'textarea', 'label' => 'Text Area', 'icon' => 'textarea', 'group' => 'basic'],
            ['type' => 'select', 'label' => 'Dropdown', 'icon' => 'select', 'group' => 'choice'],
            ['type' => 'radio', 'label' => 'Radio Group', 'icon' => 'radio', 'group' => 'choice'],
            ['type' => 'checkbox', 'label' => 'Checkboxes', 'icon' => 'checkbox', 'group' => 'choice'],
            ['type' => 'date', 'label' => 'Date Picker', 'icon' => 'date', 'group' => 'advanced'],
            ['type' => 'file', 'label' => 'File Upload', 'icon' => 'file', 'group' => 'advanced'],
            ['type' => 'heading', 'label' => 'Heading', 'icon' => 'heading', 'group' => 'layout'],
            ['type' => 'paragraph', 'label' => 'Paragraph', 'icon' => 'paragraph', 'group' => 'layout'],
            ['type' => 'divider', 'label' => 'Divider', 'icon' => 'divider', 'group' => 'layout'],
        ];
    }

    /**
     * Add a new field to the form.
     */
    public function addField(string $type, ?int $position = null): void
    {
        $defaults = $this->getFieldDefaults($type);

        $field = [
            'id' => 'field_' . Str::random(8),
            'type' => $type,
            'label' => $defaults['label'],
            'placeholder' => $defaults['placeholder'],
            'required' => false,
            'options' => $defaults['options'],
        ];

        if ($position !== null && $position >= 0 && $position <= count($this->fields)) {
            array_splice($this->fields, $position, 0, [$field]);
            $this->activeFieldIndex = $position;
        } else {
            $this->fields[] = $field;
            $this->activeFieldIndex = count($this->fields) - 1;
        }

        $this->syncActiveField();
        $this->isDirty = true;
    }

    /**
     * Handle field drop from palette at a specific position.
     */
    public function fieldDropped(string $type, int $position): void
    {
        $this->addField($type, $position);
    }

    /**
     * Remove a field by index.
     */
    public function removeField(int $index): void
    {
        if (isset($this->fields[$index])) {
            array_splice($this->fields, $index, 1);
            $this->fields = array_values($this->fields);
            $this->isDirty = true;

            if ($this->activeFieldIndex === $index) {
                $this->activeFieldIndex = null;
                $this->resetEditProperties();
            } elseif ($this->activeFieldIndex !== null && $this->activeFieldIndex > $index) {
                $this->activeFieldIndex--;
            }
        }
    }

    /**
     * Duplicate a field.
     */
    public function duplicateField(int $index): void
    {
        if (isset($this->fields[$index])) {
            $newField = $this->fields[$index];
            $newField['id'] = 'field_' . Str::random(8);
            $newField['label'] = $newField['label'] . ' (copy)';
            array_splice($this->fields, $index + 1, 0, [$newField]);
            $this->fields = array_values($this->fields);
            $this->activeFieldIndex = $index + 1;
            $this->syncActiveField();
            $this->isDirty = true;
        }
    }

    /**
     * Set the active field for editing.
     */
    public function selectField(int $index): void
    {
        $this->activeFieldIndex = $index;
        $this->syncActiveField();
    }

    /**
     * Deselect the active field.
     */
    public function deselectField(): void
    {
        $this->activeFieldIndex = null;
        $this->resetEditProperties();
    }

    /**
     * Update field order after drag-and-drop reordering.
     */
    public function reorderFields(array $orderedIds): void
    {
        $reordered = [];
        foreach ($orderedIds as $id) {
            foreach ($this->fields as $field) {
                if ($field['id'] === $id) {
                    $reordered[] = $field;
                    break;
                }
            }
        }

        $this->fields = $reordered;
        $this->isDirty = true;

        // Update active field index after reorder
        if ($this->activeFieldIndex !== null && isset($this->fields[$this->activeFieldIndex])) {
            $activeId = $this->fields[$this->activeFieldIndex]['id'] ?? null;
            if ($activeId) {
                foreach ($this->fields as $i => $field) {
                    if ($field['id'] === $activeId) {
                        $this->activeFieldIndex = $i;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Apply edits from the properties panel to the active field.
     */
    public function applyFieldEdits(): void
    {
        if ($this->activeFieldIndex === null || !isset($this->fields[$this->activeFieldIndex])) {
            return;
        }

        $this->fields[$this->activeFieldIndex]['label'] = $this->editLabel;
        $this->fields[$this->activeFieldIndex]['placeholder'] = $this->editPlaceholder;
        $this->fields[$this->activeFieldIndex]['required'] = $this->editRequired;
        $this->isDirty = true;
        // Parse options for select/radio/checkbox
        $type = $this->fields[$this->activeFieldIndex]['type'];
        if (in_array($type, ['select', 'radio', 'checkbox'])) {
            $this->fields[$this->activeFieldIndex]['options'] = array_filter(
                array_map('trim', explode("\n", $this->editOptions))
            );
        }
    }

    /**
     * Save the form to the database.
     */
    public function saveForm(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        $schema = ['fields' => $this->fields];

        if ($this->formId) {
            $form = Form::where('user_id', auth()->id())->findOrFail($this->formId);
            $form->update([
                'title' => $this->title,
                'description' => $this->description,
                'schema' => $schema,
            ]);
        } else {
            $form = Form::create([
                'user_id' => auth()->id(),
                'title' => $this->title,
                'description' => $this->description,
                'slug' => Str::lower(Str::random(10)),
                'schema' => $schema,
                'settings' => [],
            ]);
            $this->formId = $form->id;
        }

        $this->isDirty = false;
        $this->dispatch('form-saved');
        $this->redirectRoute('dashboard', ['view' => 'forms']);
    }

    public function updatedEditLabel(): void
    {
        $this->applyFieldEdits();
    }

    public function updatedEditPlaceholder(): void
    {
        $this->applyFieldEdits();
    }

    public function updatedEditRequired(): void
    {
        $this->applyFieldEdits();
    }

    public function updatedEditOptions(): void
    {
        $this->applyFieldEdits();
    }

    public function updatedTitle(): void
    {
        $this->isDirty = true;
    }

    public function updatedDescription(): void
    {
        $this->isDirty = true;
    }

    /**
     * Sync edit properties from the currently active field.
     */
    private function syncActiveField(): void
    {
        if ($this->activeFieldIndex !== null && isset($this->fields[$this->activeFieldIndex])) {
            $field = $this->fields[$this->activeFieldIndex];
            $this->editLabel = $field['label'] ?? '';
            $this->editPlaceholder = $field['placeholder'] ?? '';
            $this->editRequired = $field['required'] ?? false;
            $this->editOptions = implode("\n", $field['options'] ?? []);
        }
    }

    private function resetEditProperties(): void
    {
        $this->editLabel = '';
        $this->editPlaceholder = '';
        $this->editRequired = false;
        $this->editOptions = '';
    }

    /**
     * Get sensible defaults for each field type.
     */
    private function getFieldDefaults(string $type): array
    {
        return match ($type) {
            'text' => ['label' => 'Text Field', 'placeholder' => 'Enter text...', 'options' => []],
            'email' => ['label' => 'Email Address', 'placeholder' => 'you@example.com', 'options' => []],
            'number' => ['label' => 'Number', 'placeholder' => '0', 'options' => []],
            'phone' => ['label' => 'Phone Number', 'placeholder' => '+1 (555) 000-0000', 'options' => []],
            'url' => ['label' => 'Website URL', 'placeholder' => 'https://', 'options' => []],
            'textarea' => ['label' => 'Message', 'placeholder' => 'Type your message...', 'options' => []],
            'select' => ['label' => 'Select Option', 'placeholder' => 'Choose...', 'options' => ['Option 1', 'Option 2', 'Option 3']],
            'radio' => ['label' => 'Choose One', 'placeholder' => '', 'options' => ['Option 1', 'Option 2', 'Option 3']],
            'checkbox' => ['label' => 'Select Multiple', 'placeholder' => '', 'options' => ['Option 1', 'Option 2', 'Option 3']],
            'date' => ['label' => 'Date', 'placeholder' => 'Select a date', 'options' => []],
            'file' => ['label' => 'Upload File', 'placeholder' => 'Choose file...', 'options' => []],
            'heading' => ['label' => 'Section Heading', 'placeholder' => '', 'options' => []],
            'paragraph' => ['label' => 'Add some descriptive text here.', 'placeholder' => '', 'options' => []],
            'divider' => ['label' => '', 'placeholder' => '', 'options' => []],
            default => ['label' => 'Field', 'placeholder' => '', 'options' => []],
        };
    }

    public function render()
    {
        return view('livewire.form-builder');
    }
}
