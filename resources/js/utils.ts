import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import dayjs from "dayjs";

export function cn(...inputs: ClassValue[]) {
	return twMerge(clsx(inputs));
}

export function formatReadableDate(toFormat: Date) {
	if (dayjs().isSame(toFormat, "day") && dayjs().isSame(toFormat, "year")) {
		return dayjs(toFormat).format("h:mm A");
	} else if (dayjs().isSame(toFormat, "year")) {
		return dayjs(toFormat).format("ddd, DD MMM, h:mm A");
	} else if (dayjs().isSame(toFormat, "day")) {
		return dayjs(toFormat).format("DD MMM, h:mm A");
	} else {
		return dayjs(toFormat).format("ddd, DD MMM YYYY, h:mm A");
	}
}