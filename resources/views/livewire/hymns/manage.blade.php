<?php

use App\Models\Hymn;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use function Livewire\Volt\{state, computed, uses};

uses([WithPagination::class]);

state([
    'q' => '',
    'editing' => null,
    'number' => '',
    'title' => '',
    'content_md' => '',
    'is_published' => true,
]);

$hymns = computed(function () {
    $query = Hymn::query()
        ->orderBy('number', 'asc')
        ->orderBy('created_at', 'desc');

    if ($this->q) {
        $q = trim($this->q);
        $query->where(function ($qb) use ($q) {
            if (is_numeric($q)) {
                $qb->orWhere('number', intval($q));
            }
            $qb->orWhere('title', 'like', '%'.$q.'%');
        });
    }

    return $query->paginate(12);
});

$resetForm = function () {
    $this->reset(['editing','number','title','content_md','is_published']);
    $this->is_published = true;
};

$save = function () {
    $rules = [
        'number' => ['required','integer','min:1', Rule::unique('hymns','number')->ignore($this->editing)],
        'title' => ['required','string','max:255'],
        'content_md' => ['required','string'],
        'is_published' => ['boolean'],
    ];
    $this->validate($rules);

    $payload = [
        'number' => intval($this->number),
        'title' => $this->title,
        'content_md' => $this->content_md,
        'is_published' => (bool) $this->is_published,
    ];

    if ($this->editing) {
        $h = Hymn::find($this->editing);
        if ($h) {
            $h->update($payload);
        }
        session()->flash('message','Hymn updated');
    } else {
        Hymn::create($payload);
        session()->flash('message','Hymn created');
    }

    $this->resetForm();
};

$edit = function (int $id) {
    $h = Hymn::find($id);
    if (!$h) return;
    $this->editing = $h->id;
    $this->number = $h->number;
    $this->title = $h->title;
    $this->content_md = $h->content_md;
    $this->is_published = (bool) $h->is_published;
};

$delete = function (int $id) {
    $h = Hymn::find($id);
    if ($h) {
        $h->delete();
        session()->flash('message','Hymn deleted');
    }
};

?>

<section class="px-4 lg:px-10 mt-6" data-animate>
    <div class="rounded-sm p-6 bg-white shadow-md shadow-purple-200 dark:bg-zinc-900 dark:text-neutral-100 max-w-7xl mx-auto">
        @if (session()->has('message'))
            <div class="mb-4 p-4 rounded-sm bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">{{ session('message') }}</div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-2xl font-semibold text-[#45016a]">Manage Hymns</div>
            <div class="flex gap-2 w-full lg:w-auto">
                <input type="text" wire:model.live.debounce.300ms="q" placeholder="Search by number or title" class="w-full sm:w-64 rounded-sm border border-gray-300 p-3 dark:bg-zinc-800 dark:border-zinc-700" />
            </div>
        </div>

        <div class="mt-6 grid lg:grid-cols-2 gap-6">
            <div class="rounded-sm border p-4 dark:border-zinc-700">
                <div class="grid gap-3">
                    <input type="number" min="1" wire:model.live="number" placeholder="Hymn number" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @error('number') <div class="text-sm text-red-600">{{ $message }}</div> @enderror

                    <input type="text" wire:model.live="title" placeholder="Title" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700" />
                    @error('title') <div class="text-sm text-red-600">{{ $message }}</div> @enderror

                    <div class="grid gap-2">
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','h1')">H1</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','h2')">H2</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','bold')">Bold</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','italic')">Italic</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','link')">Link</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','ul')">• List</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','ol')">1. List</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','quote')">Quote</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','code')">Code</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','inlinecode')">`Code`</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','space')">Space</button>
                            <button type="button" class="rounded-sm border px-3 py-1 text-sm dark:border-zinc-700" onclick="mdApply('hymnMd','backspace')">Backspace</button>
                        </div>
                        <textarea id="hymnMd" wire:model.live="content_md" rows="10" placeholder="# Heading\n\nContent in markdown" class="rounded-sm border p-3 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    </div>
                    @error('content_md') <div class="text-sm text-red-600">{{ $message }}</div> @enderror

                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" wire:model.live="is_published" class="rounded-sm" /> <span>Published</span></label>

                    <div class="flex gap-2 justify-end">
                        <button type="button" class="rounded-sm border px-4 py-2 dark:border-zinc-700" wire:click="{{ $editing ? 'resetForm' : 'resetForm' }}">Reset</button>
                        <button type="button" class="rounded-sm bg-[#45016a] text-white px-5 py-2 hover:bg-[#ffc0cb] hover:text-[#45016a]" wire:click="save">{{ $editing ? 'Update' : 'Save' }}</button>
                    </div>
                </div>

                <div class="mt-6">
                    @php
                        $md = $content_md;
                        $html = $md;
                        $html = preg_replace('/^######\s*(.*)$/m', '<h6>$1</h6>', $html);
                        $html = preg_replace('/^#####\s*(.*)$/m', '<h5>$1</h5>', $html);
                        $html = preg_replace('/^####\s*(.*)$/m', '<h4>$1</h4>', $html);
                        $html = preg_replace('/^###\s*(.*)$/m', '<h3>$1</h3>', $html);
                        $html = preg_replace('/^##\s*(.*)$/m', '<h2>$1</h2>', $html);
                        $html = preg_replace('/^#\s*(.*)$/m', '<h1>$1</h1>', $html);
                        $html = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $html);
                        $html = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $html);
                        $html = preg_replace('/\[(.*?)\]\((.*?)\)/s', '<a href="$2">$1</a>', $html);
                        $html = preg_replace('/\n{2,}/', "\n\n", $html);
                        $parts = array_filter(preg_split('/\n\n/', $html));
                    @endphp
                    <div class="rounded-sm border p-4 dark:border-zinc-700">
                        @foreach($parts as $p)
                            {!! preg_match('/^<h[1-6]>/', $p) ? $p : '<p>'.nl2br($p).'</p>' !!}
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-sm border p-4 dark:border-zinc-700">
                @if($this->hymns->count())
                    <div class="grid gap-3">
                        @foreach($this->hymns as $h)
                            <div class="rounded-sm border p-3 flex items-start justify-between gap-3 dark:border-zinc-700">
                                <div>
                                    <div class="font-semibold text-[#45016a]">Hymn {{ $h->number }} — {{ $h->title }}</div>
                                    <div class="text-xs text-neutral-600">{{ $h->is_published ? 'Published' : 'Unpublished' }}</div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="rounded-sm border px-3 py-2 dark:border-zinc-700" wire:click="edit({{ $h->id }})">Edit</button>
                                    <button type="button" class="rounded-sm border px-3 py-2 text-red-600 dark:border-zinc-700" wire:click="delete({{ $h->id }})">Delete</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $this->hymns->links() }}</div>
                @else
                    <div class="text-sm text-neutral-600">No hymns yet.</div>
                @endif
            </div>
        </div>
    </div>
    <div wire:loading class="mt-2 text-sm text-neutral-600">Loading...</div>
</section>
<script>
function mdApply(id, action){
  var el=document.getElementById(id); if(!el) return; var v=el.value; var s=el.selectionStart||0; var e=el.selectionEnd||0; var sel=v.substring(s,e);
  function setValue(t,ns,ne){ el.value=t; el.dispatchEvent(new Event('input',{bubbles:true})); el.focus(); el.setSelectionRange(ns,ne); }
  if(action==='bold'){ var rep='**'+(sel||'text')+'**'; setValue(v.substring(0,s)+rep+v.substring(e), s+2, s+2+(sel||'text').length); return; }
  if(action==='italic'){ var rep='*'+(sel||'text')+'*'; setValue(v.substring(0,s)+rep+v.substring(e), s+1, s+1+(sel||'text').length); return; }
  if(action==='inlinecode'){ var rep='`'+(sel||'code')+'`'; setValue(v.substring(0,s)+rep+v.substring(e), s+1, s+1+(sel||'code').length); return; }
  if(action==='space'){ var rep=' ' ; setValue(v.substring(0,s)+rep+v.substring(e), s+1, s+1); return; }
  if(action==='backspace'){ if(s===e && s>0){ setValue(v.substring(0,s-1)+v.substring(e), s-1, s-1); } else { setValue(v.substring(0,s)+v.substring(e), s, s); } return; }
  var startLine=v.lastIndexOf('\n', s-1)+1; var lines=v.substring(startLine,e).split('\n');
  function prefixAll(prefix){ var block=v.substring(startLine,e); var rep=block.replace(/^/gm,prefix); setValue(v.substring(0,startLine)+rep+v.substring(e), startLine, startLine+rep.length); }
  if(action==='h1'){ prefixAll('# '); return; }
  if(action==='h2'){ prefixAll('## '); return; }
  if(action==='quote'){ prefixAll('> '); return; }
  if(action==='ul'){ prefixAll('- '); return; }
  if(action==='ol'){ var rep=lines.map(function(line,i){ return (i+1)+'. '+line; }).join('\n'); setValue(v.substring(0,startLine)+rep+v.substring(e), startLine, startLine+rep.length); return; }
  if(action==='code'){ var rep='```\n'+(sel||'')+'\n```'; setValue(v.substring(0,s)+rep+v.substring(e), s+4, s+4+(sel||'').length); return; }
  if(action==='link'){ var text=sel||'link'; var rep='['+text+'](https://)'; setValue(v.substring(0,s)+rep+v.substring(e), s+1, s+1+text.length); return; }
}
</script>
