<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\DoctorPolyclinic;
use App\Services\DoctorPolyclinicService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DoctorPolyclinicServiceTest extends TestCase
{

    use DatabaseTransactions;
    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function test_create_succesfully(): void
    {
        $mockIcon = Mockery::mock(UploadedFile::class);
        $mockIcon->shouldReceive('isValid')->once()->andReturn(true);
        $mockIcon->shouldReceive('getClientOriginalExtension')->once()->andReturn('svg');
        $mockIcon->shouldReceive('getMimeType')->once()->andReturn('image/svg+xml');
        $mockIcon->shouldReceive('storeAs')->once()->andReturn('doctor_polyclinics/test.svg');

        // Gunakan fake DB alih-alih mocking alias model
        $service = new DoctorPolyclinicService();
        $response = $service->create('Poli Umum', $mockIcon);

        $this->assertTrue($response->status);
        $this->assertEquals('Poliklinik Dokter Berhasil Dibuat', $response->message);

        $this->assertDatabaseHas('doctor_polyclinics', [
            'name' => 'Poli Umum',
        ]);
    }


    public function test_create_fail_file_format_not_a_svg(): void
    {
        $mockIcon = Mockery::mock(UploadedFile::class);
        $mockIcon->shouldReceive('isValid')->once()->andReturn(true);
        $mockIcon->shouldReceive('getClientOriginalExtension')->once()->andReturn('png');


        $service = new DoctorPolyclinicService();
        $response = $service->create('Poli Umum', $mockIcon);

        $this->assertFalse($response->status);
        $this->assertEquals('File Harus Berupa SVG', $response->message);
    }

    public function test_get_data_succesfully()
    {
        $name = 'Poli Testing';
        $icon = 'poli-testing.svg';

        DoctorPolyclinic::factory()->create(['name' => $name, 'icon' => $icon]);
        DoctorPolyclinic::factory()->count(5)->create();

        $service = new DoctorPolyclinicService();

        $response = $service->get();

        $this->assertTrue($response->status);
        $this->assertNotEmpty($response->data);
        $this->assertEquals($name, $response->data[0]["name"]);
        $this->assertCount(6, $response->data);
    }

    public function test_get_data_by_id()
    {
        $name = 'Poli Testing';
        $icon = 'poli-testing.svg';

        $docterPolyclinic = DoctorPolyclinic::factory()->create(['name' => $name, 'icon' => $icon]);
        DoctorPolyclinic::factory()->count(5)->create();
        $id = $docterPolyclinic->id;
        $service = new DoctorPolyclinicService();

        $response = $service->get($id);

        $this->assertTrue($response->status);
        $this->assertEquals($name, $response->data["name"]);
    }

    public function test_delete_succesfully()
    {
        $service = new DoctorPolyclinicService();
        $doctorPolyclinic = DoctorPolyclinic::factory()->create();
        $id = $doctorPolyclinic->id;

        $response = $service->delete($id);

        $this->assertTrue($response->status);
        $this->assertEquals('Polyclinic Dihapus', $response->message);
        $this->assertDatabaseEmpty('doctor_polyclinics');
    }

    public function test_delete_fail_id_not_found()
    {
        $service = new DoctorPolyclinicService();
        $doctorPolyclinic = DoctorPolyclinic::factory()->create();

        $response = $service->delete(999);

        $this->assertFalse($response->status);
        $this->assertEquals('Polyclinic Tidak Ditemukan', $response->message);
        $this->assertDatabaseCount('doctor_polyclinics', 1);
    }

    public function test_update_succesfully()
    {
        $mockIcon = Mockery::mock(UploadedFile::class);
        $mockIcon->shouldReceive('isValid')->once()->andReturn(true);
        $mockIcon->shouldReceive('getClientOriginalExtension')->once()->andReturn('svg');
        $mockIcon->shouldReceive('getMimeType')->once()->andReturn('image/svg+xml');
        $mockIcon->shouldReceive('storeAs')->once()->andReturn('doctor_polyclinics/test.svg');

        // Gunakan fake DB alih-alih mocking alias model
        $service = new DoctorPolyclinicService();
        $name = 'Poli Umum';
        $icon = 'poli-umum.svg';

        $doctorPolyclinic = DoctorPolyclinic::factory()->create(['name' => $name, 'icon' => $icon]);
        $id = $doctorPolyclinic->id;

        $newName = 'Poli Umum Baru';
        $icon = 'poli-umum-baru.svg';

        $service->update($id);
    }
}
