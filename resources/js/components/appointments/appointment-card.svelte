<script lang="ts">
	import dayjs from "dayjs";
	import type { Appointment } from "@/types/appointment";
	import { cn } from "@/utils";

	let { appointment }: { appointment: Appointment } = $props();
</script>

<div>
	<button
		class={cn(
			"hover:bg-accent flex flex-col gap-2 rounded-lg border p-3 text-left w-full",
		)}
	>
		<div class="flex w-full flex-col gap-1">
			<div class="flex items-start">
				<div>
					<div class="text-sm text-muted-foreground">
						{`${dayjs(appointment.start_time).format("HH:mm")} - ${dayjs(appointment.end_time).format("HH:mm")}`}
					</div>
					<div class="font-semibold">
						{appointment.patient_name}
					</div>
				</div>

				<div class={cn("ml-auto text-xs")}></div>
			</div>
			<div class="text-xs font-medium">Some more info</div>
		</div>
		<div class="text-muted-foreground line-clamp-2 text-xs">
			{appointment.remarks}
		</div>
	</button>
</div>
