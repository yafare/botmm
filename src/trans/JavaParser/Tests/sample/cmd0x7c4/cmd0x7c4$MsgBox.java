package tencent.im.oidb.cmd0x7c4;

import com.tencent.mobileqq.pb.ByteStringMicro;
import com.tencent.mobileqq.pb.MessageMicro;
import com.tencent.mobileqq.pb.MessageMicro.FieldMap;
import com.tencent.mobileqq.pb.PBBytesField;
import com.tencent.mobileqq.pb.PBField;
import com.tencent.mobileqq.pb.PBUInt32Field;

public final class cmd0x7c4$MsgBox
  extends MessageMicro
{
  static final MessageMicro.FieldMap __fieldMap__;
  public final PBBytesField bytes_msg = PBField.initBytes(ByteStringMicro.EMPTY);
  public final PBUInt32Field uint32_reason_id = PBField.initUInt32(0);
  
  static
  {
    ByteStringMicro localByteStringMicro = ByteStringMicro.EMPTY;
    __fieldMap__ = MessageMicro.initFieldMap(new int[] { 8, 18 }, new String[] { "uint32_reason_id", "bytes_msg" }, new Object[] { Integer.valueOf(0), localByteStringMicro }, MsgBox.class);
  }
}


/* Location:              /Users/LeBlanc/Tools/6.6.9/classes4-dex2jar.jar!/tencent/im/oidb/cmd0x7c4/cmd0x7c4$MsgBox.class
 * Java compiler version: 6 (50.0)
 * JD-Core Version:       0.7.1
 */