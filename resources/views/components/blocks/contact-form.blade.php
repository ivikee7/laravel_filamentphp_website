@props(['data'])

<form action="#" method="POST" class="p-6 sm:p-8 bg-white border border-slate-200 rounded-3xl shadow-sm space-y-4 my-6">
    @csrf
    <input type="hidden" name="form_identifier" value="{{ $data['form_identifier'] ?? 'default' }}">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1">
            <label class="text-xs font-semibold text-slate-700">Full Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-[#006633] focus:outline-none" placeholder="Jane Doe">
        </div>

        <div class="space-y-1">
            <label class="text-xs font-semibold text-slate-700">Email Address</label>
            <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-[#006633] focus:outline-none" placeholder="jane@example.com">
        </div>
    </div>

    <div class="space-y-1">
        <label class="text-xs font-semibold text-slate-700">Message</label>
        <textarea name="message" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-[#006633] focus:outline-none" placeholder="How can we help you?"></textarea>
    </div>

    <button type="submit" class="w-full sm:w-auto bg-[#006633] hover:bg-[#004d26] text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-sm">
        Send Message
    </button>
</form>
