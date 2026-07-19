import { NotificationIcon } from "../../../../../components/ui";
import { GlobalBtn } from "../../../../../components/ui/btn";

interface Props {
    unread?: number;
}

const NotificationButton = ({ unread = 0 }: Props) => {
    return (
        <GlobalBtn icon={NotificationIcon} />
    );
}

export default NotificationButton;