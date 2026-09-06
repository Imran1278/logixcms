<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Throwable;

class DownloadController extends Controller
{
    /**
     * Public Page - Grouped by Categories
     */
    public function publicIndex(): View
    {
        $downloads = Download::latest()->get()->groupBy('category');
        return view('student.downloads', compact('downloads'));
    }

    /**
     * Admin List Page
     */
    public function index(): View
    {
        $downloads = Download::latest()->paginate(12);
        return view('admin.downloads.index', compact('downloads'));
    }

    /**
     * Admin Store New Document Form
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'file'        => 'required|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:10240', // Max 10MB
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                $fileName = time() . '_' . uniqid() . '.' . $extension;

                $uploadDirectory = public_path('uploads/forms');
                if (!File::exists($uploadDirectory)) {
                    File::makeDirectory($uploadDirectory, 0755, true, true);
                }

                $file->move($uploadDirectory, $fileName);
                $filePath = 'uploads/forms/' . $fileName;

                Download::create([
                    'title'       => $validated['title'],
                    'category'    => $validated['category'],
                    'file_type'   => strtoupper($extension),
                    'description' => $validated['description'] ?? null,
                    'file_path'   => $filePath,
                ]);

                return redirect()->back()->with('success', 'Form uploaded successfully!');
            }

            return redirect()->back()->with('error', 'Please attach a valid document file.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Error uploading document: ' . $e->getMessage());
        }
    }

    /**
     * Admin Delete Form
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $download = Download::findOrFail($id);

            // Safe physical file removal
            $absolutePath = public_path($download->file_path);
            if (File::exists($absolutePath) && is_file($absolutePath)) {
                File::delete($absolutePath);
            }

            $download->delete();

            return redirect()->back()->with('success', 'Form document deleted successfully!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete requested form.');
        }
    }
}