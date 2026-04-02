<?php

namespace App\Livewire\Instructor\Courses;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Requirement;
use App\Models\Course;

class Requirements extends Component
{
    public Course $course;
    public $requirements = [];

    #[Validate('required|string|max:255')]
    public $name;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->getRequirements();
    }

    public function getRequirements()
    {
        $this->requirements = $this->course->requirements()
            ->orderBy('order', 'asc')
            ->get()
            ->keyBy('id')
            ->toArray();
    }

    public function store()
    {
        $this->validateOnly('name');

        $this->course->requirements()->create([
            'name' => $this->name,
        ]);

        $this->reset('name');
        $this->getRequirements();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Requerimiento agregado!',
            'text' => 'El requerimiento del curso se ha guardado correctamente.'
        ]);
    }

    public function update()
    {
        $this->validate([
            'requirements.*.name' => 'required|string|max:255'
        ]);

        foreach ($this->requirements as $id => $requirementData) {
            Requirement::where('id', $id)->update([
                'name' => $requirementData['name']
            ]);
        }

        $this->getRequirements();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'text' => 'Los requerimientos se han actualizado correctamente.'
        ]);
    }

    public function destroy(Requirement $requirement)
    {
        $requirement->delete();
        $this->getRequirements();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Eliminado!',
            'text' => 'El requerimiento ha sido eliminado correctamente.'
        ]);
    }

    public function reorder($requirementsData)
    {
        foreach ($requirementsData as $data) {
            Requirement::where('id', $data['id'])->update([
                'name' => $data['name'],
                'order' => $data['order']
            ]);
        }

        $this->getRequirements();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Sincronizado!',
            'text' => 'El orden y los cambios se han guardado.'
        ]);
    }

    public function render()
    {
        return view('livewire.instructor.courses.requirements');
    }
}
