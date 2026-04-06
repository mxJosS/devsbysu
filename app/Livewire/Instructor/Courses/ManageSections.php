<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use App\Models\Section;
use App\Models\Course;

class ManageSections extends Component
{
    public Course $course;
    public $name;
    public $sections = [];
    public $sectionEdit = [
        'id' => null,
        'name' => null
    ];

    public function mount(Course $course)
    {
        $this->course = $course;



        $this->loadSections();
    }

    public function loadSections()
    {
        $this->sections = Section::where('course_id', $this->course->id)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function store($position = null)
    {
        $this->validate([
            'name' => 'required'
        ]);

        if (!$position) {
            $position = $this->course->sections()->count() + 1;
        } else {
            $this->course->sections()
                ->where('order', '>=', $position)
                ->increment('order');
        }

        $this->course->sections()->create([
            'name' => $this->name,
            'order' => $position
        ]);

        $this->reset('name');
        $this->loadSections();

        $this->dispatch('section-added');

        $this->dispatch('swal', [
            'title' => '¡Sección agregada!',
            'text' => 'La nueva sección se guardó con éxito.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.instructor.courses.manage-sections');
    }

    public function edit(Section $section)
    {
        $this->sectionEdit = [
            'id' => $section->id,
            'name' => $section->name
        ];
    }

    public function update()
    {
        $this->validate([
            'sectionEdit.name' => 'required'
        ]);

        Section::find($this->sectionEdit['id'])->update([
            'name' => $this->sectionEdit['name']
        ]);

        $this->reset('sectionEdit');
        $this->loadSections();

        $this->dispatch('swal', [
            'title' => '¡Actualizado!',
            'text' => 'El nombre de la sección se actualizó correctamente.',
            'icon' => 'success'
        ]);
    }

    public function destroy(Section $section)
    {
        $section->delete();
        $this->loadSections();

        $this->dispatch('swal', [
            'title' => '¡Eliminado!',
            'text' => 'La sección se eliminó correctamente.',
            'icon' => 'success'
        ]);
    }
}
