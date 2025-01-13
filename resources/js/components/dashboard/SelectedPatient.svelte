<script lang="ts">
	import type { Visit } from "@/types/visit";
	import dayjs from "dayjs";
	let {
		now,
		selectedVisit = $bindable(),
	}: {
		now: Date;
		selectedVisit: Visit | null;
	} = $props();
	console.log(selectedVisit);
</script>

<div class="rounded-md border h-full">
	<div class="p-4">
		<div class="text-2xl font-bold text-center" aria-live="polite">
			{dayjs(now).format("h:mm:ss A")}
		</div>
		<div class="text-lg text-center text-muted-foreground">
			{dayjs(now).format("dddd, MMMM D, YYYY")}
		</div>
	</div>
	<div>
		{#if selectedVisit}
			<div class="border-t p-4">
				<div class="text-sm text-muted-foreground">
					#{selectedVisit.patient.tenant_patient_number}
				</div>
				<div class="font-semibold">{selectedVisit.patient.name}</div>
			</div>
		{/if}
	</div>
</div>
